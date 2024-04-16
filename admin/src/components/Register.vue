<template>
    <div v-if="isVisible" class="popup-overlay">
        <div class="register-box">
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Register a new membership</p>

                    <form @submit.prevent="register">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Full name" v-model="user.name" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Lastname" v-model="user.lastname" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" v-model="user.email" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" v-model="user.password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                            <div class="col-4">
                                <button @click.prevent="close" class="btn btn-primary btn-block">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.card -->
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const error = ref('');
const isVisible = ref(false);
const user = ref({
    name: '',
    lastname: '',
    email: '',
    password: ''
});

const register = async () => {
    try {
        const response = await axios.post('http://localhost:8000/api/registration', user.value);
        if (response.status === 204) {
            close()
        }
    } catch (err) {
        error.value = err.response?.data?.message || 'Failed to log in';
    }
};

function close() {
    isVisible.value = false;
}

defineExpose({
    isVisible,
    close
});
</script>

<style scoped>
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-content {
    background: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.4);
}
</style>
