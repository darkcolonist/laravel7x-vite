import './bootstrap.js';
import React from 'react';
import ReactDOM from 'react-dom/client';
import '../css/app.css'

import { ThemeProvider, createTheme } from '@mui/material/styles';
import CssBaseline from '@mui/material/CssBaseline';

const darkTheme = createTheme({
  palette: {
    mode: 'dark',
  },
});

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <ThemeProvider theme={darkTheme}>
      <CssBaseline />
      <div>let the magic begin!</div>
    </ThemeProvider>
  </React.StrictMode>
)
