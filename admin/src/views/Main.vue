<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const apiData = ref(null);
const myEvents = ref(null);
const eventData = ref(null);
const userData = ref(null);
const token = ref(localStorage.getItem('access_token'))
const error = ref('');

async function fetchEvents() {
    const config = {
        headers: {
            Authorization: 'Bearer ' + token.value
        }
    };

    try {
        const response = await axios.get('http://localhost:8000/api/event', config);
        apiData.value = response.data.data;
    } catch (error) {
        if (error.response.status === 401) {
            localStorage.removeItem('access_token');
            await router.push('/login')
        }
    }
}

async function fetchMyEvents() {
    const config = {
        headers: {
            Authorization: 'Bearer ' + token.value
        }
    };

    try {
        const response = await axios.get('http://localhost:8000/api/my-events', config);
        myEvents.value = response.data.data;
    } catch (error) {
        if (error.response.status === 401) {
            localStorage.removeItem('access_token');
            await router.push('/login')
        }
    }
}

async function updateEvents() {
    setInterval(fetchEvents, 30000)
}

async function updateEvent(id) {
    setInterval(() => {
        fetchEvent(id)
    }, 30000)
}

async function fetchUser() {
    const config = {
        headers: {
            Authorization: 'Bearer ' + token.value
        }
    };

    try {
        const response = await axios.get('http://localhost:8000/api/me', config);
        userData.value = response.data.data;
    } catch (error) {
        if (error.response.status === 401) {
            localStorage.removeItem('access_token');
            await router.push('/login')
        }
    }
}

async function subscribe(id) {
    const config = {
        headers: {
            Authorization: 'Bearer ' + token.value
        }
    };

    try {
        const response = await axios.post('http://localhost:8000/api/event/' + id + '/subscribe', {}, config);
        userData.value = response.data.data;
        await fetchEvent(id)
    } catch (error) {
        if (error.response.status === 401) {
            localStorage.removeItem('access_token');
            await router.push('/login')
        }
    }
}

async function unsubscribe(id) {
    const config = {
        headers: {
            Authorization: 'Bearer ' + token.value
        }
    };

    try {
        const response = await axios.post('http://localhost:8000/api/event/' + id + '/unsubscribe', {}, config);
        userData.value = response.data.data;
        await fetchEvent(id)
    } catch (error) {
        if (error.response.status === 401) {
            localStorage.removeItem('access_token');
            await router.push('/login')
        }
    }
}

async function fetchEvent(id) {
    const config = {
        headers: {
            Authorization: 'Bearer ' + token.value
        }
    };

    try {
        const response = await axios.get('http://localhost:8000/api/event/' + id, config);
        eventData.value = response.data.data;
    } catch (error) {
        if (error.response.status === 401) {
            localStorage.removeItem('access_token');
            await router.push('/login')
        }
    }
}

const logout = async () => {
    const config = {
        headers: {
            Authorization: 'Bearer ' + token.value
        }
    };
    try {
        const response = await axios.post('http://localhost:8000/api/auth/logout', {}, config);
        if (response.status === 200) {
            localStorage.removeItem('access_token');

            await router.push('/');
        }
    } catch (err) {
        error.value = err.response?.data?.message || 'Failed to log in';
    }
};

onMounted(() => {
    fetchEvents();
    fetchUser();
    updateEvents();
    fetchMyEvents();
});
</script>

<template>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block" v-if="!token">
                    <a style="cursor: pointer" class="nav-link">Войти</a>
                </li>
                <li @click.prevent="logout" class="nav-item d-none d-sm-inline-block" v-else>
                    <a style="cursor: pointer" class="nav-link">Выйти</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                        class="fas fa-th-large"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index3.html" class="brand-link">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block" v-if="userData">{{ userData.name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item menu-open">
                            <ul class="nav nav-treeview">
                                <li class="nav-item" v-if="apiData" v-for="item in apiData">
                                    <p class="nav-link" @click.prevent="fetchEvent(item.id)">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ item.name }}</p>
                                    </p>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="info">
                            <a href="#" class="d-block">Мои события</a>
                        </div>
                    </div>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item menu-open">
                            <ul class="nav nav-treeview">
                                <li class="nav-item" v-if="myEvents" v-for="item in myEvents">
                                    <p class="nav-link" @click.prevent="fetchEvent(item.id)">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ item.name }}</p>
                                    </p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div style="padding: 20px 0 0 50px" v-if="eventData">
                <p>{{ eventData.name }}</p>
                <p>{{ eventData.text }}</p>
                <button @click.prevent="subscribe(eventData.id)" v-if="eventData.created_by !== userData.id">Принять участие</button>
                <button @click.prevent="unsubscribe(eventData.id)" v-else>Отказаться от участия</button>

                <div v-if="eventData.users">
                    <p class="mt-5">Участники</p>
                    <div v-for="item in eventData.users">
                        <p>{{ item.name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
