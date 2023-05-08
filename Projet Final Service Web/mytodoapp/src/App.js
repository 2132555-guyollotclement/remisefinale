import React, { useState } from 'react';
import Taches from './components/Taches';
import Login from './components/Login';

function App() {
  const [isLoggedIn, setIsLoggedIn] = useState(false);

  const handleLogin = () => {
    setIsLoggedIn(true);
  };

  const handleLogout = () => {
    setIsLoggedIn(false);
  };

  return (
    <div className="App">
      <Login isLoggedIn={isLoggedIn} onLogin={handleLogin} onLogout={handleLogout} />
      {isLoggedIn && <Taches />}
    </div>
  );
}

export default App;
