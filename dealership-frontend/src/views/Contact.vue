<script setup>
import { ref } from 'vue'
import api from '../services/api'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const form = ref({
    name: '',
    email: '',
    subject: '',
    message: '',
})

const loading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const submitForm = async () => {
    loading.value = true
    successMessage.value = ''
    errorMessage.value = ''

    try {
        const response = await api.post('/contact', form.value)

        successMessage.value = response.data.message

        form.value = {
            name: '',
            email: '',
            subject: '',
            message: '',
        }
    } catch (error) {
        if (error.response?.status === 422) {
            errorMessage.value = t('contact.validationError')
        } else {
            errorMessage.value = t('contact.generalError')
        }
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="text-center mb-4">
                    <h1>{{ t('contact.title') }}</h1>

                    <p class="text-muted">
                        {{ t('contact.subtitle') }}
                    </p>
                </div>

                <!-- Success message -->
                <div
                    v-if="successMessage"
                    class="alert alert-success"
                >
                    {{ successMessage }}
                </div>

                <!-- Error message -->
                <div
                    v-if="errorMessage"
                    class="alert alert-danger"
                >
                    {{ errorMessage }}
                </div>

                <form @submit.prevent="submitForm">

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">
                            {{ t('contact.name') }}
                        </label>

                        <input
                            v-model="form.name"
                            type="text"
                            class="form-control"
                            :placeholder="t('contact.namePlaceholder')"
                            required
                        >
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">
                            {{ t('contact.email') }}
                        </label>

                        <input
                            v-model="form.email"
                            type="email"
                            class="form-control"
                            :placeholder="t('contact.emailPlaceholder')"
                            required
                        >
                    </div>

                    <!-- Subject -->
                    <div class="mb-3">
                        <label class="form-label">
                            {{ t('contact.subject') }}
                        </label>

                        <input
                            v-model="form.subject"
                            type="text"
                            class="form-control"
                            :placeholder="t('contact.subjectPlaceholder')"
                            required
                        >
                    </div>

                    <!-- Message -->
                    <div class="mb-3">
                        <label class="form-label">
                            {{ t('contact.message') }}
                        </label>

                        <textarea
                            v-model="form.message"
                            class="form-control"
                            rows="6"
                            :placeholder="t('contact.messagePlaceholder')"
                            required
                        ></textarea>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="btn btn-primary"
                        :disabled="loading"
                    >
                        {{ loading ? t('contact.sending') : t('contact.sendMessage') }}
                    </button>

                </form>

            </div>

        </div>

    </div>
</template>