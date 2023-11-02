<template>
  <div class="login">
    <h1>Login</h1>
    <form @submit.prevent="login">
      <div class="form-group">
        <label for="email">Email</label>
        <input
          id="email"
          type="email"
          v-model="form.email"
          required
        />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input
          id="password"
          type="password"
          v-model="form.password"
          required
        />
      </div>

      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
    };
  },

  methods: {
    async login() {
      try {
        const response = await axios.post('/login', {
          email: this.form.email,
          password: this.form.password,
        });

        if (response.data.token) {
          // Store the token securely (e.g., in local storage)
          localStorage.setItem('jwtToken', response.data.token);

          // Redirect or perform other actions upon successful login
          this.$router.push({ name: 'home' });
        } else {
          // Handle login failure, show an error message, etc.
          // Example: this.$q.notify({ message: 'Login failed', color: 'negative' });
        }
      } catch (error) {
        // Handle API request error, e.g., show a network error message
        // Example: this.$q.notify({ message: 'Network error', color: 'negative' });
        console.error(error);
      }
    },
  },
};
</script>
