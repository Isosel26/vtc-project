<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background-color: #0a0a0a;
  color: #ffffff;
  font-family: 'Inter', sans-serif;
  min-height: 100vh;
}

#app {
  min-height: 100vh;
}

/* Classes utilitaires réutilisables */
.page {
  min-height: 100vh;
  background-color: #0a0a0a;
  display: flex;
  flex-direction: column;
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
  opacity: 0.06;
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
  opacity: 0.06;
}

.card {
  background-color: #1a1a1a;
  border: 1px solid #2a2a2a;
  border-radius: 16px;
  padding: 2rem;
  width: 100%;
  max-width: 480px;
  position: relative;
  z-index: 1;
}

.card h2 {
  font-size: 1.5rem;
  font-weight: 900;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 1.5rem;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: #aaaaaa;
  margin-bottom: 0.4rem;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 0.75rem 1rem;
  background-color: #2a2a2a;
  border: 1px solid #3a3a3a;
  border-radius: 10px;
  color: #ffffff;
  font-size: 0.95rem;
  font-family: 'Inter', sans-serif;
  outline: none;
  transition: border-color 0.2s;
}

.form-group input:focus,
.form-group select:focus {
  border-color: #888888;
}

.form-group select option {
  background-color: #2a2a2a;
}

.btn {
  width: 100%;
  padding: 0.85rem;
  background-color: #888888;
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  cursor: pointer;
  transition: background-color 0.2s;
  margin-top: 0.5rem;
}

.btn:hover {
  background-color: #aaaaaa;
}

.btn:disabled {
  background-color: #444444;
  cursor: not-allowed;
}

.link {
  color: #aaaaaa;
  text-decoration: none;
  font-size: 0.85rem;
  text-align: center;
  display: block;
  margin-top: 1rem;
  transition: color 0.2s;
}

.link:hover {
  color: #ffffff;
}

.error {
  color: #ff6b6b;
  font-size: 0.85rem;
  text-align: center;
  margin-top: 0.75rem;
}

.warning-box {
  background-color: #2a2000;
  border: 1px solid #ffc107;
  border-radius: 10px;
  padding: 1rem;
  text-align: center;
  color: #ffc107;
  font-size: 0.85rem;
  margin-bottom: 1.5rem;
}
</style>
