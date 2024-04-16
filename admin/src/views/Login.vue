<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Login</h3>
        </div>
        <div class="card-body">
            <form @submit.prevent="login">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" v-model="credentials.email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" v-model="credentials.password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Log In</button>
            </form>

            <button @click.prevent="openPopup" class="btn btn-primary btn-block mt-2">Register</button>
        </div>
        <RegistrationPopup ref="registrationPopup"/>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import RegistrationPopup from '../components/Register.vue';
const registrationPopup = ref(null);
const router = useRouter();
const credentials = ref({
    email: '',
    password: ''
});
const error = ref('');

function openPopup() {
    registrationPopup.value.isVisible = true;
}

const login = async () => {
    try {
        const response = await axios.post('http://localhost:8000/api/auth/login', credentials.value);
        console.log('Login successful:', response.data);
        if (response.data && response.data.access_token) {
            localStorage.setItem('access_token', response.data.access_token);

            await router.push('/');
        }
    } catch (err) {
        error.value = err.response?.data?.message || 'Failed to log in';
    }
};
</script>

<style>
label {
    margin-right: 10px;
}
input[type="text"],
input[type="password"] {
    margin-bottom: 10px;
}
</style>
