<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import authService from '../services/auth'
import { useAuthStore } from '../stores/auth'
import { useI18n } from 'vue-i18n'

const {t} = useI18n()

const router = useRouter()
const authStore = useAuthStore()

const form = reactive({

    name: '',
    email: '',
    password: '',
    password_confirmation: '',

})

const error = ref('')
const loading = ref(false)

const register = async () => {

    error.value = ''
    loading.value = true

    try {

        const response = await authService.register(form)

        authStore.setAuth(response.data.user, response.data.token)

        router.push('/')

    } catch (err) {

        error.value = t('register.registrationFailed')

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
                        {{ t('register.title') }}
                    </h2>

                    <div
                        v-if="error"
                        class="alert alert-danger"
                    >
                        {{ error }}
                    </div>

                    <form @submit.prevent="register">

                        <div class="mb-3">

                            <label>{{ t('register.name') }}</label>

                            <input
                                v-model="form.name"
                                class="form-control"
                            >

                        </div>

                        <div class="mb-3">

                            <label>{{ t('register.email') }}</label>

                            <input
                                v-model="form.email"
                                type="email"
                                class="form-control"
                            >

                        </div>

                        <div class="mb-3">

                            <label>{{ t('register.password') }}</label>

                            <input
                                v-model="form.password"
                                type="password"
                                class="form-control"
                            >

                        </div>

                        <div class="mb-3">

                            <label>{{ t('register.confirmPassword') }}</label>

                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                class="form-control"
                            >

                        </div>

                        <button
                            class="btn btn-success w-100"
                            :disabled="loading"
                        >

                            {{ loading ? t('register.registering') : t('register.register') }}

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</template>