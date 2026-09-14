<template>
    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow-sm border-0">

                    <div class="card-body p-4">

                        <h2 class="fw-bold mb-4">
                            {{ t('profile.title') }}
                        </h2>

                        <!-- Loading -->
                        <div v-if="loading" class="text-center py-4">
                            <div
                                class="spinner-border"
                                role="status"
                            >
                                <span class="visually-hidden">
                                    {{ t('profile.loading') }}
                                </span>
                            </div>

                            <p class="text-muted mt-2">
                                {{ t('profile.loadingProfile') }}
                            </p>
                        </div>

                        <!-- Error -->
                        <div
                            v-else-if="error"
                            class="alert alert-danger"
                        >
                            {{ error }}
                        </div>

                        <!-- Profile -->
                        <div v-else-if="user">

                            <div class="text-center mb-4">

                                <div
                                    class="profile-avatar mx-auto mb-3"
                                >
                                    <img
                                        v-if="user.profile_picture"
                                        :src="getImageUrl(user.profile_picture)"
                                        :alt="t('profile.profilePicture')"
                                    >

                                    <i
                                        v-else
                                        class="bi bi-person-fill"
                                    ></i>
                                </div>

                                <h4 class="fw-bold mb-1">
                                    {{ user.name }}
                                </h4>

                                <p class="text-muted mb-0">
                                    {{ user.email }}
                                </p>

                                
                                <div class="mt-3">
                                    <input
                                        type="file"
                                        class="form-control"
                                        accept="image/jpeg,image/png,image/webp"
                                        @change="handleFileChange"
                                    >

                                    <button
                                        class="btn btn-primary mt-3"
                                        :disabled="uploadingPicture || !selectedFile"
                                        @click="uploadProfilePicture"
                                    >
                                        <span
                                            v-if="uploadingPicture"
                                            class="spinner-border spinner-border-sm me-2"
                                            role="status"
                                        ></span>

                                        {{ uploadingPicture
                                            ? t('profile.uploading')
                                            : t('profile.changePicture')
                                        }}
                                    </button>

                                </div>

                                <div
                                    v-if="pictureSuccess"
                                    class="alert alert-success mt-3"
                                >
                                    {{ pictureSuccess }}
                                </div>

                                <div
                                    v-if="pictureError"
                                    class="alert alert-danger mt-3"
                                >
                                    {{ pictureError }}
                                </div>

                            </div>

                            <hr>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">
                                        {{ t('profile.name') }}
                                    </label>

                                    <div class="fw-semibold">
                                        {{ user.name }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">
                                        {{ t('profile.email') }}
                                    </label>

                                    <div class="fw-semibold">
                                        {{ user.email }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">
                                        {{ t('profile.accountType') }}
                                    </label>

                                    <div class="fw-semibold text-capitalize">
                                        {{ user.role }}
                                    </div>
                                </div>

                            </div>

                        </div>

                        <hr class="my-4">

                        <div>
                            <h4 class="fw-bold mb-3">
                                {{ t('profile.changePassword') }}
                            </h4>

                            <form @submit.prevent="changePassword">

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ t('profile.currentPassword') }}
                                    </label>

                                    <input
                                        v-model="currentPassword"
                                        type="password"
                                        class="form-control"
                                        autocomplete="current-password"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ t('profile.newPassword') }}
                                    </label>

                                    <input
                                        v-model="newPassword"
                                        type="password"
                                        class="form-control"
                                        autocomplete="new-password"
                                        minlength="8"
                                        required
                                    >

                                    <small class="text-muted">
                                        {{ t('profile.passwordHint') }}
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ t('profile.confirmNewPassword') }}
                                    </label>

                                    <input
                                        v-model="newPasswordConfirmation"
                                        type="password"
                                        class="form-control"
                                        autocomplete="new-password"
                                        minlength="8"
                                        required
                                    >
                                </div>

                                <div
                                    v-if="passwordSuccess"
                                    class="alert alert-success"
                                >
                                    {{ passwordSuccess }}
                                </div>

                                <div
                                    v-if="passwordError"
                                    class="alert alert-danger"
                                >
                                    {{ passwordError }}
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-dark"
                                    :disabled="passwordLoading"
                                >
                                    <span
                                        v-if="passwordLoading"
                                        class="spinner-border spinner-border-sm me-2"
                                        role="status"
                                    ></span>

                                    {{ passwordLoading
                                        ? t('profile.changingPassword')
                                        : t('profile.changePasswordButton')
                                    }}
                                </button>

                            </form>

                        </div>



                    </div>

                </div>

            </div>

        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import profileService from '@/services/profile'
import { useAuthStore } from '@/stores/auth'
import { useI18n } from 'vue-i18n'

const {t} = useI18n()

const authStore = useAuthStore()

const user = ref(null)
const loading = ref(false)
const error = ref('')

const selectedFile = ref(null)
const uploadingPicture = ref(false)
const pictureError = ref('')
const pictureSuccess = ref('')

const currentPassword = ref('')
const newPassword = ref('')
const newPasswordConfirmation = ref('')

const passwordLoading = ref(false)
const passwordSuccess = ref('')
const passwordError = ref('')

const fetchProfile = async () => {
    loading.value = true
    error.value = ''

    try {
        const response = await profileService.getProfile()

        user.value = response.data.user
        
        authStore.user = response.data.user

    } catch (err) {
        console.error('Failed to load profile:', err)

        error.value = t('profile.failedToLoad')
    } finally {
        loading.value = false
    }
}


const handleFileChange = (event) => {
    selectedFile.value = event.target.files[0] || null

    pictureError.value = ''
    pictureSuccess.value = ''
}

const uploadProfilePicture = async () => {
    if (!selectedFile.value) {
        pictureError.value =  t('profile.selectImage')
        return
    }

    uploadingPicture.value = true
    pictureError.value = ''
    pictureSuccess.value = ''

    try {
        const formData = new FormData()

        formData.append(
            'profile_picture',
            selectedFile.value
        )

        const response =
            await profileService.updateProfilePicture(formData)

        user.value = response.data.user

        selectedFile.value = null

        pictureSuccess.value = t('profile.pictureUpdated')

    } catch (err) {
        console.error(
            'Failed to upload profile picture:',
            err
        )

        if (err.response?.data?.errors?.profile_picture) {
            pictureError.value =
                err.response.data.errors.profile_picture[0]
        } else {
            pictureError.value = t('profile.uploadPictureFailed')
        }

    } finally {
        uploadingPicture.value = false
    }
}
// fixing picture path
const getImageUrl = (imagePath) => {

    if (!imagePath) {
        return ''
    }

    if (
        imagePath.startsWith('http://') ||
        imagePath.startsWith('https://')
    ) {
        return imagePath
    }

    const baseUrl = import.meta.env.VITE_API_URL.replace('/api', '')

    return `${baseUrl}/storage/${imagePath}`
}

const changePassword = async () => {
    passwordLoading.value = true
    passwordSuccess.value = ''
    passwordError.value = ''

    try {
        const response = await profileService.changePassword({
            current_password: currentPassword.value,
            new_password: newPassword.value,
            new_password_confirmation: newPasswordConfirmation.value
        })

        passwordSuccess.value = response.data.message

        currentPassword.value = ''
        newPassword.value = ''
        newPasswordConfirmation.value = ''

    } catch (err) {
        console.error('Failed to change password:', err)

        if (err.response?.data?.message) {
            passwordError.value = err.response.data.message
        } else if (err.response?.data?.errors) {
            const errors = err.response.data.errors

            passwordError.value =
                Object.values(errors)[0][0]
        } else {
            passwordError.value = t('profile.unableToChangePassword')
        }

    } finally {
        passwordLoading.value = false
    }
}


onMounted(() => {
    fetchProfile()
})
</script>

<style scoped>
.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f1f1f1;
    font-size: 50px;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>