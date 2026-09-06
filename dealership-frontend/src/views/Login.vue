<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import authService from '../services/auth'
import { useAuthStore } from '../stores/auth'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const router = useRouter()
const authStore = useAuthStore()

const form = reactive({
    email: '',
    password: '',
})

const error = ref('')
const loading = ref(false)

const login = async () => {

    error.value = ''
    loading.value = true

    try {

        const response = await authService.login(form)

        authStore.setAuth(response.data.user, response.data.token)

        if (response.data.user.role === 'admin') {

            router.push('/admin/dashboard')

        } else {

            router.push('/')

        }

    } catch (err) {

        error.value = err.response?.data?.message ||  t('login.loginFailed') 

    } finally {

        loading.value = false

    }

}
</script>

<template>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="text-center mb-4">
                        {{ t('login.title') }}
                    </h2>

                    <div
                        v-if="error"
                        class="alert alert-danger"
                    >
                        {{ error }}
                    </div>

                    <form @submit.prevent="login">

                        <div class="mb-3">

                            <label><b>{{t('login.email')}}</b></label>

                            <input
                                v-model="form.email"
                                type="email"
                                class="form-control"
                            >

                        </div>

                        <div class="mb-3">

                            <label><b>{{ t('login.password') }}</b></label>

                            <input
                                v-model="form.password"
                                type="password"
                                class="form-control"
                            >

                        </div>

                        <button
                            class="btn btn-primary w-100"
                            :disabled="loading"
                        >

                            {{ loading ? t('login.loggingIn') : t('login.login') }}

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</template>