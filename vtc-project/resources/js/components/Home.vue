<template>
  <div class="page">
    <div class="home-content">
      <h1 class="brand">Driver Valence</h1>
      <p class="tagline">RÉSERVEZ DÈS MAINTENANT</p>

      <div class="info-cards">
        <div class="info-card">Besoin d'aller d'un <strong>point A</strong> à un <strong>point B</strong> ?</div>
        <div class="info-card">Disponible <strong>7/7j — 24/24h</strong></div>
        <div class="info-card">Sur <strong>RÉSERVATION</strong> ou appel de <strong>DERNIÈRE MINUTE</strong></div>
      </div>

      <div class="actions">
        <router-link to="/login" class="btn-link">Connexion</router-link>
        <router-link to="/register" class="btn-link btn-link--outline">Inscription</router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Home',
};
</script>

<style scoped>
.page {
  min-height: 100vh;
  background-color: #0a0a0a;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  position: relative;
  overflow: hidden;
}

.page::before {
  content: '';
  position: absolute;
  top: -100px;
  right: -100px;
  width: 350px;
  height: 350px;
  background: #ffffff;
  border-radius: 50% 40% 60% 30% / 40% 50% 30% 60%;
  opacity: 0.07;
}

.page::after {
  content: '';
  position: absolute;
  bottom: -120px;
  left: -80px;
  width: 400px;
  height: 400px;
  background: #ffffff;
  border-radius: 60% 40% 30% 50% / 50% 60% 40% 30%;
  opacity: 0.07;
}

.home-content {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  width: 100%;
  max-width: 400px;
}

.brand {
  font-size: 2.8rem;
  font-weight: 900;
  font-style: italic;
  letter-spacing: 0.02em;
  text-align: center;
}

.tagline {
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.2em;
  color: #aaaaaa;
  text-align: center;
}

.info-cards {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  width: 100%;
}

.info-card {
  background-color: #888888;
  border-radius: 12px;
  padding: 1rem 1.5rem;
  font-size: 0.95rem;
  text-align: center;
  color: #ffffff;
  line-height: 1.5;
}

.info-card strong {
  font-weight: 900;
}

.actions {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  width: 100%;
  margin-top: 0.5rem;
}

.btn-link {
  display: block;
  text-align: center;
  padding: 0.85rem;
  background-color: #888888;
  color: #ffffff;
  border-radius: 10px;
  text-decoration: none;
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  transition: background-color 0.2s;
}

.btn-link:hover {
  background-color: #aaaaaa;
}

.btn-link--outline {
  background-color: transparent;
  border: 1px solid #888888;
  color: #888888;
}

.btn-link--outline:hover {
  background-color: #888888;
  color: #ffffff;
}
</style>
