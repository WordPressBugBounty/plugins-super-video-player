import React from 'react-dom';
import AppContainer from './Index';
import './admin.scss';
document.addEventListener('DOMContentLoaded', () => {
  const adminEl = document.getElementById('svpPlayerDashboard');
  const isPremium = adminEl.dataset.ispremium === '1' ? true : false;

  // console.log("I am from dashboard admin:", isPremium);

  React.createRoot(adminEl).render(<AppContainer isPremium={isPremium} />)
});