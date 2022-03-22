<template>
    <h2>Page {{currentPage}}</h2>
    <div class="container card-container" v-if="posts && posts.length">
        <div class="card" v-for="post of posts" :key="post.id">
            <div class="card-body">
                <h5 class="card-title">{{post.from_name}}</h5>
                <p class="card-text">{{post.message}}</p>
                <p class="card-text">{{parseDate(post.created_time) }}</p>
            </div>
        </div>
    </div>
    <div class="container">
      <nav class="d-flex justify-content-center py-3 fixed-bottom">
        <ul class="nav nav-pills" v-for="index in 10" :key="index">
          <li class="nav-item"><a href="#" class="nav-link" v-on:click="nextPage(index)">Page {{index}}</a></li>
        </ul>
      </nav>
    </div>
</template>

<script>

import { defineComponent } from '@vue/runtime-core';
import axios from 'axios';

export default defineComponent( {
  name: 'get-posts',
  data() {
    return {
      posts: [],
      errors: [],
      currentPage: 1,
    }
  },
  
  created() {
    this.nextPage(1);
  },

  methods: {
      nextPage(page) {
        axios.get(`http://localhost/techtest/dist/getposts.php?page=${page}`)
            .then(response => {
            
            this.posts = response.data.posts;
            this.currentPage = page;
            })
            .catch(e => {
            this.errors.push(e)
            })
      },
      parseDate(timeString) {
        let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        let creationDate = new Date(timeString);
        let date = '';
        date += creationDate.getDate() + ' ';
        date += months[creationDate.getMonth()] + ' ';
        date += creationDate.getFullYear() + ' ';
        date += String(creationDate.getHours()).padStart(2, '0') + ':';
        date += String(creationDate.getMinutes()).padStart(2, '0');
        return date;
      }
  }
})
 

</script>

<style scoped>
    .card-text {
        text-align: left;
    }

    .card-container {
        margin-bottom: 6em;
    }

    nav {
        background-color: white;
        margin-top: 2em;
        box-shadow: 2px 0px 15px rgba(0,0,0,0.5)
    }
</style>
