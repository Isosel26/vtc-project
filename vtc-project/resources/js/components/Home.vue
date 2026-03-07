<template>
    <div>
      <h1>Bienvenue sur la plateforme DriverValence</h1>
      <p>Choisissez une option :</p>
      <router-link to="/login">Connexion</router-link>
      <router-link to="/register">Inscription</router-link>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Home',
  };
  </script>
  