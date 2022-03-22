<template>
<div class="container">
  <h1 class="display-1">Hi, Supermetrics!</h1>
  <p>I thought I'd give you a little overview of what I've built here. Some of my methodology, and rationale behind the choices that I've made.</p>
  <p>Most of this will be repeated in the README file.</p>
  <h2>Client Side</h2>
  <p>Firstly, I've built this client-side in Vue. Honestly, it might not follow best-practice but I haven't had much exposure to JavaScript SPA frameworks
    so I had to learn Vue effectively from scratch for this project, so I hope that it's OK.</p>
  <p>The app is divided into three separate pages with their own App, this one, the blog posts page, and the user dashboard page.</p>
  <p>Most of the heavy lifting from the API is performed in the PHP API that I've written, with the client side doing mostly simple
    translation on the data it gets back from the API. The fetch requests from the server are powered by axios.</p>
  <h2>Server Side</h2>
  <p>On the server side, the site is driven by PHP 8.1. The server side app is divided into two parts. There's the public facing php scripts 
      (getposts.php and getuserdata.php) - these act as simple interfaces for the application itself which lives in the Application folder. There's
      a base Api class, which is an interface that the other classes extend from, and they use a naming convention that would enable them to be called
      using a default SPL Autoloader.</p>
  <p>There is a 'tests' folder which contains a suite of PHP Unit tests (PHPUnit 9+ might be required to run these under PHP 8)</p>
  <p>This app is built on Vue 3, and PHP 8.1 (which is a hard requirement as I'm using typed returns in my methods).</p>
</div>

</template>

<script>

export default {
  name: 'App',
  components: {
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.display-1 {
  font-weight: bold;
}

.container p {
  text-align: left;
}
</style>
