import React from 'react-dom';
import '../../bpl-tools/Admin/style.scss';
import { dashboardInfo } from './utils/data';
import App from './App';
document.addEventListener('DOMContentLoaded', () => {
  const adminEl = document.getElementById("svpPlayerDashboard");
  const info = JSON.parse(adminEl.dataset.info)

  React.createRoot(adminEl).render(<App {...dashboardInfo(info)} />)
});