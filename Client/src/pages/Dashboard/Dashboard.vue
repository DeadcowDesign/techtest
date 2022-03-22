<template>
<div class="component">
  <div class="container">
    <h2>Dashboard</h2>
    <select class="form-select" v-model="getuser">
      <option selected disabled value="default">{{loadingMessage}}</option>
      <option v-for="user in users" :key="user" v-bind:value="user">
        {{user}}
      </option>
    </select>
  </div>

  <div class="container" v-if="notEmpty(userData)">
    <h2 class="display-1">Hi, {{userData.username}}</h2>
    <div class="card">
        <div class="card-body">
          <h5 class="card-title display-3">{{userData.totalPosts}}</h5>
          <p class="card-text">Yout Total Post Count</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
          <h5 class="card-title display-3">{{userData.averageCharacters}}</h5>
          <p class="card-text">Your Average Characters Per Post</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
          <blockquote class="blockquote">{{userData.longestPost}}</blockquote>
          <p class="card-text">Your Longest Post</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
          <table class="table">
            <thead>
            <tr>
              <th v-for="month in userPostsMonths" :key="month">
                {{month}}
              </th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td v-for="count in userData.postMonths" :key="count">
                {{count}}
              </td>
            </tr>
            </tbody>
          </table>
          <p class="card-text">Your Posts By Month</p>
        </div>
    </div>
  </div>
</div>
</template>
<script>

import { defineComponent } from '@vue/runtime-core';
import axios from 'axios';

export default defineComponent( {
  name: 'show-dashboard',
  data() {
    return {
      users: [],
      userData: {},
      getuser: 'default',
      loadingMessage: 'Please wait while User list loads...',
      userPostsMonths: [],
      errors: [],
      currentPage: 1,
    }
  },
  
  created() {
    this.getUsers();
  },
  watch: {
    getuser(newUser) {
      this.getUserDashboard(newUser);
    }
  },
  methods: {
    notEmpty(testObj) {
      return Object.keys(testObj).length;
    },
      getUsers() {
        axios.get('http://localhost/techtest/API/getuserdata.php')
        .then(response => {
          this.users = response.data.users;
          this.loadingMessage = 'Please choose a user from the list';
        })
        .catch(e => {
          this.errors.push(e);
        })
      },
      getUserDashboard(username) {
        axios.get(`http://localhost/techtest/API/getuserdata.php?username=${username}`)
          .then(response => {
            this.userData = response.data;
            this.userPostsMonths = Object.keys(response.data.postMonths);
          })
          .catch(e => {
            this.errors.push(e);
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
    .card {
      margin-bottom: 2em;
    }

    .card-container {
        margin-bottom: 6em;
    }

    .card blockquote {
      text-align: left;
    }
    
    nav {
        background-color: white;
        margin-top: 2em;
        box-shadow: 2px 0px 15px rgba(0,0,0,0.5)
    }
</style>
