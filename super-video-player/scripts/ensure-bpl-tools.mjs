#!/usr/bin/env node
/**
 * Bootstrap the shared bpl-tools library.
 *
 * bpl-tools stays a SEPARATE repository, checked out as a sibling of this
 * plugin, because it is shared by every bPlugins product. Vendoring it would
 * fork it 12 ways; moving it inside node_modules would break the build, since
 * wp-scripts' babel-loader excludes node_modules and bpl-tools ships raw JSX.
 *
 * This script makes that layout reproducible on a clean machine:
 *   git clone <plugin> && npm ci && npm run build
 * `prebuild` calls this, which clones bpl-tools at the pinned commit and
 * installs its dependencies if they are missing.
 *
 * Usage:
 *   node scripts/ensure-bpl-tools.mjs            ensure present + installed
 *   node scripts/ensure-bpl-tools.mjs --update   check out the pinned ref
 *   node scripts/ensure-bpl-tools.mjs --check    verify only, non-zero on drift (CI)
 */

import { spawnSync } from 'node:child_process';
import { existsSync, readFileSync } from 'node:fs';
import { dirname, join, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const PLUGIN_ROOT = resolve(dirname(fileURLToPath(import.meta.url)), '..');

const pkg = JSON.parse(readFileSync(join(PLUGIN_ROOT, 'package.json'), 'utf8'));
const config = pkg.bplTools ?? {};

const REPOSITORY = config.repository ?? 'https://github.com/bPlugins/bpl-tools.git';
const REF = config.ref ?? 'main';
const TARGET = resolve(PLUGIN_ROOT, config.path ?? '../bpl-tools');

const args = new Set(process.argv.slice(2));
const UPDATE = args.has('--update');
const CHECK_ONLY = args.has('--check');

/** Entry points this plugin imports. If these are missing, the build will fail. */
const REQUIRED_ENTRIES = [
	'Components/index.js',
	'ProControls/index.js',
	'utils/functions.js',
	'utils/data.js',
	'utils/getCSS.js',
	'Admin/Welcome',
];

const log = (msg) => console.log(`[bpl-tools] ${msg}`);
const warn = (msg) => console.warn(`[bpl-tools] ⚠ ${msg}`);

const run = (cmd, cmdArgs, cwd) =>
	spawnSync(cmd, cmdArgs, {
		cwd,
		stdio: 'inherit',
		// Windows resolves npm/git through the shell.
		shell: process.platform === 'win32',
	});

const capture = (cmd, cmdArgs, cwd) => {
	const result = spawnSync(cmd, cmdArgs, {
		cwd,
		encoding: 'utf8',
		shell: process.platform === 'win32',
	});
	return 0 === result.status ? (result.stdout ?? '').trim() : null;
};

/*
 * Every git call carries core.longpaths. bpl-tools has deeply nested component
 * paths, and a checkout under a long parent directory silently produces an
 * incomplete object store on Windows without it — the clone reports success and
 * the working tree comes out empty.
 */
const LONGPATHS = ['-c', 'core.longpaths=true'];
const git = (gitArgs, cwd) => run('git', [...LONGPATHS, ...gitArgs], cwd);
const gitOut = (gitArgs, cwd) => capture('git', [...LONGPATHS, ...gitArgs], cwd);

const fail = (msg) => {
	console.error(`[bpl-tools] ✖ ${msg}`);
	process.exit(1);
};

/* ------------------------------------------------------------------ */
/* 1. Make sure the checkout exists                                     */
/* ------------------------------------------------------------------ */

if (!existsSync(TARGET)) {
	if (CHECK_ONLY) fail(`Not found at ${TARGET}. Run: npm run bpl-tools`);

	log(`Not found at ${TARGET}`);
	log(`Cloning ${REPOSITORY} …`);

	if (0 !== git(['clone', REPOSITORY, TARGET]).status) {
		fail(`Clone failed. Clone it manually to ${TARGET}`);
	}

	// Persist it in the new checkout so later git use inherits it.
	git(['config', 'core.longpaths', 'true'], TARGET);

	if ('main' !== REF && 0 !== git(['checkout', REF], TARGET).status) {
		fail(`Could not check out pinned ref ${REF}`);
	}
}

if (!existsSync(join(TARGET, '.git'))) {
	warn(`${TARGET} exists but is not a git checkout — leaving it alone.`);
}

/* ------------------------------------------------------------------ */
/* 2. Report / reconcile the pinned commit                              */
/* ------------------------------------------------------------------ */

const head = gitOut(['rev-parse', 'HEAD'], TARGET);

if (head && REF !== 'main') {
	const pinned = gitOut(['rev-parse', REF], TARGET) ?? REF;

	if (head !== pinned) {
		const dirty = gitOut(['status', '--porcelain'], TARGET);

		if (UPDATE) {
			if (dirty) {
				fail(
					`Refusing to check out ${REF}: ${TARGET} has uncommitted changes.\n` +
					`             Commit or stash them first.`
				);
			}
			log(`Checking out pinned ref ${REF.slice(0, 12)} …`);
			git(['fetch', 'origin'], TARGET);
			if (0 !== git(['checkout', REF], TARGET).status) {
				fail(`Could not check out ${REF}`);
			}
		} else if (CHECK_ONLY) {
			fail(
				`Pinned to ${pinned.slice(0, 12)} but checkout is at ${head.slice(0, 12)}.\n` +
				`             Run: npm run bpl-tools:update`
			);
		} else {
			warn(
				`Checkout is at ${head.slice(0, 12)}, package.json pins ${pinned.slice(0, 12)}.\n` +
				`             Building against the local checkout. To match the pin: npm run bpl-tools:update`
			);
		}
	}
}

/* ------------------------------------------------------------------ */
/* 3. Make sure its own dependencies are installed                      */
/* ------------------------------------------------------------------ */
/* The plugin imports bpl-tools modules that pull in @dnd-kit, dompurify,
 * react-ace and others. Those resolve from bpl-tools/node_modules, not from
 * this plugin's, so the build fails without them. */

if (!existsSync(join(TARGET, 'node_modules'))) {
	if (CHECK_ONLY) fail('Dependencies not installed. Run: npm run bpl-tools');

	log('Installing its dependencies (first run only, this takes a minute) …');

	// --legacy-peer-deps mirrors how this workspace is installed: the bPlugins
	// plugins run React 19 while @wordpress/scripts still peer-declares React 18.
	const install = run(
		'npm',
		[existsSync(join(TARGET, 'package-lock.json')) ? 'ci' : 'install', '--legacy-peer-deps', '--no-audit', '--no-fund'],
		TARGET
	);

	if (0 !== install.status) {
		fail(`Dependency install failed. Run it manually:\n             cd ${TARGET} && npm install --legacy-peer-deps`);
	}
}

/* ------------------------------------------------------------------ */
/* 4. Sanity-check the entry points the plugin imports                  */
/* ------------------------------------------------------------------ */

const missing = REQUIRED_ENTRIES.filter((entry) => !existsSync(join(TARGET, entry)));

if (missing.length) {
	fail(
		`Checkout is missing entry points this plugin imports:\n` +
		missing.map((m) => `               - ${m}`).join('\n') +
		`\n             The pinned ref may be wrong, or bpl-tools has been restructured.`
	);
}

log(`Ready at ${TARGET}${head ? ` (${head.slice(0, 12)})` : ''}`);
