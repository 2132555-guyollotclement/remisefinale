import React, { useState, useEffect } from 'react';
import Modal from 'react-modal';
import '../Taches.css';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCheck } from '@fortawesome/free-solid-svg-icons';
import { faTrash } from '@fortawesome/free-solid-svg-icons';
import { faRotate } from '@fortawesome/free-solid-svg-icons';
import Api from '../utils/Api'; // Importez la méthode Api et assurez-vous que vous avez défini l'URL de base pour l'API.

Modal.setAppElement('#root');

const Taches = () => {
  const [taches, setTaches] = useState([]);
  const [citation, setCitation] = useState('');
  const [modalIsOpen, setModalIsOpen] = useState(false);
  const [nouvelleTache, setNouvelleTache] = useState({
    titre: '',
    description: '',
  });

  useEffect(() => {
    fetchTaches();
    fetchCitation();
  }, []);

  const fetchTaches = () => {
    Api.get('/taches')
      .then((response) => {
        setTaches(response.data);
      })
      .catch((error) => {
        console.error('Erreur lors de la récupération des tâches:', error);
      });
  };

  const fetchCitation = () => {
    Api.get('https://api.quotable.io/random')
      .then((response) => {
        setCitation(`${response.data.content} — ${response.data.author}`);
      })
      .catch((error) => {
        console.error('Erreur lors de la récupération de la citation:', error);
      });
  };

  const ajouterTache = () => {
    Api.post('/taches', nouvelleTache)
      .then((response) => {
        setTaches((prevState) => [...prevState, response.data]);
        setModalIsOpen(false);
        fetchTaches();
      })
      .catch((error) => {
        console.error("Erreur lors de l'ajout de la tâche:", error);
      });
  };
  


  const terminerTache = (tacheId) => {
    Api.put(`/taches/${tacheId}`, { termine: 1 })
      .then((response) => {
        const updatedTaches = taches.map((tache) => (tache.id === tacheId ? response.data : tache));
        setTaches(updatedTaches);
        fetchTaches();
      })
      .catch((error) => {
        console.error('Erreur lors de la mise à jour de la tâche:', error);
      });
  };

  const supprimerTache = (tacheId) => {
    Api.delete(`/taches/${tacheId}`)
      .then(() => {
        const tachesRestantes = taches.filter((tache) => tache.id !== tacheId);
        setTaches(tachesRestantes);
      })
      .catch((error) => {
        console.error('Erreur lors de la suppression de la tâche:', error);
      });
  };

  const handleChange = (e) => {
    setNouvelleTache({ ...nouvelleTache, [e.target.name]: e.target.value });
  };

  const openModal = () => {
    setModalIsOpen(true);
  };

  const closeModal = () => {
    setModalIsOpen(false);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    ajouterTache();
    };
    
    return (
      <div>
        <div className="liste-taches-exemple">
          <div className={`post-it en-cours`}>
            <h3>Listes des tâches à faire</h3>
          </div>
          <div className={`post-it completee`}>
            <h3>Listes des tâches terminées</h3>
          </div>
        </div>
    
        <h2 className="citation-du-jour">
          <u>Citations</u> :
          <FontAwesomeIcon
            icon={faRotate}
            onClick={() => fetchCitation()}
            style={{
              marginLeft: '30px',
              cursor: 'pointer',
              color: 'green',
              fontSize: '27px',
              transition: 'transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out',
            }}
          />
          <p>
            <i>{citation}</i>
          </p>
        </h2>
        <div className="container">
          <button className="button" onClick={openModal}>
            Ajouter une tâche
          </button>
        </div>
    
        <Modal
          isOpen={modalIsOpen}
          onRequestClose={closeModal}
          contentLabel="Ajouter une tâche"
          className="modal"
          overlayClassName="modal-overlay"
        >
          <h2>Ajouter une tâche</h2>
          <form onSubmit={handleSubmit}>
            <label htmlFor="titre">Titre</label>
            <input
              id="titre"
              type="text"
              value={nouvelleTache.titre}
              onChange={(e) => handleChange(e)}
              name="titre"
            />
    
            <label htmlFor="description">Description</label>
            <textarea
              id="description"
              value={nouvelleTache.description}
              onChange={(e) => handleChange(e)}
              name="description"
            ></textarea>
    
            <button type="submit" className="ajouter-tache">
              Ajouter
            </button>
          </form>
        </Modal>
    
        <div className="liste-taches">
          {taches.map((tache, index) => (
            <div
              key={`${tache.id}-${index}`}
              className={`post-it ${tache.termine == 1 ? 'completee' : 'en-cours'}`}
            >
              <div style={{ display: 'flex', paddingBottom: 10, justifyContent: 'space-between' }}>
                {tache.termine == 0 && (
                  <FontAwesomeIcon
                    icon={faCheck}
                    className="icon"
                    onClick={() => terminerTache(tache.id)}
                    style={{
                      marginRight: '10px',
                      cursor: 'pointer',
                      color: 'green',
                      fontSize: '28px',
                      transition: 'transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out',
                    }}
                  />
                )}
                <FontAwesomeIcon
                  icon={faTrash}
                  className="icon"
                  onClick={() => supprimerTache(tache.id)}
                  style={{
                    cursor: 'pointer',
                    color: 'red',
                    fontSize: '24px',
                    transition: 'transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out',
                  }}
                />
              </div>
              <h3>{tache.titre}</h3>
              <p>
                <i>{tache.description}</i>
              </p>
            </div>
          ))}
        </div>
      </div>
    );
};

export default Taches;
    