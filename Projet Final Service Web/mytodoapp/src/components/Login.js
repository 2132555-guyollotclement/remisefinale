import React, { useState } from 'react';
import Api from '../utils/Api';
import '../Login.css';

const Login = ({ isLoggedIn, onLogin, onLogout }) => {
  const [certification, setcertification] = useState({ username: '', password: '', api_key: ''});
  const [apiKey, setApiKey] = useState(null);

  const handleChange = (e) => {
    setcertification({ ...certification, [e.target.name]: e.target.value });
  };

  const handleLogout = () => {
    setApiKey(null);
    setcertification({ username: '', password: '', api_key: '' });
    onLogout();
  };



  const handleSubmit = (e) => {
    e.preventDefault();
    login();
  };

  const login = () => {
    Api.post('/login', certification)
      .then((response) => {
        if (response.data.api_key) {
          setApiKey(response.data.api_key);
          onLogin();
        } else {
          alert('Nom d\'utilisateur ou mot de passe incorrect');
        }
      })
      .catch((error) => {
        console.error('Erreur lors de la connexion:', error);
      });
  };

  const generateApiKey = () => {
    Api.post('/api_key', certification)
      .then((response) => {
        if (response.status === 201) {
          setApiKey(response.data.api_key);
        }
      })
      .catch((error) => {
        console.error('Erreur lors de la génération de la clé API:', error);
      });
  };

  if (isLoggedIn) {
    return (
      <div className="login-container">
        <h3>Vous êtes connecté(e)</h3>
        <button className="login-button" onClick={handleLogout}>Se déconnecter</button>
        {apiKey && (
        <div className="api-key-section">
          <h3>Clé API:</h3>
          <button onClick={() => alert(apiKey)} className="api-key-button">Afficher l'ancienne clé API</button>
          <button onClick={generateApiKey} className="api-key-button">Générer une nouvelle clé API</button>
        </div>
      )}
      </div>
    );
  }

  return (
    <div className="login-container">
      <h2>Connexion</h2>
      <form onSubmit={handleSubmit} className="login-form">
        <div className="input-field">
          <label htmlFor="username">Nom d'utilisateur</label>
          <input
            id="username"
            type="text"
            value={certification.username}
            onChange={handleChange}
            name="username"
          />
        </div>

        <div className="input-field">
          <label htmlFor="password">Mot de passe</label>
          <input
            id="password"
            type="password"
            value={certification.password}
            onChange={handleChange}
            name="password"
          />
        </div>

        <button type="submit" className="login-button">Se connecter</button>
      </form>
      {apiKey && (
        <div className="api-key-section">
          <h3>Clé API:</h3>
          <button onClick={() => alert(apiKey)} className="api-key-button">Afficher l'ancienne clé API</button>
          <button onClick={generateApiKey} className="api-key-button">Générer une nouvelle clé API</button>
        </div>
      )}
    </div>
  );
};

export default Login;