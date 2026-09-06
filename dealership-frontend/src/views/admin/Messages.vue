<script setup>
import { ref, onMounted } from 'vue'
import messagesService from '../../services/messages'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const messages = ref([])
const loading = ref(true)
const errorMessage = ref('')

const loadMessages = async () => {
    loading.value = true
    errorMessage.value = ''

    try {
        const response = await messagesService.getMessages()

        messages.value = response.data.messages
    } catch (error) {
        console.error(error)

        errorMessage.value = t('adminMessages.loadError')
    } finally {
        loading.value = false
    }
}

const formatDate = (date) => {
    return new Date(date).toLocaleString()
}

const markAsRead = async (message) => {
    try {
        await messagesService.markAsRead(message.id)

        message.is_read = true
    } catch (error) {
        console.error(error)

        errorMessage.value = t('adminMessages.markReadError')
    }
}

const deleteMessage = async (message) => {
        const confirmed = confirm(
            t('adminMessages.deleteConfirmation')
        )

        if (!confirmed) {
            return
        }

        try {
            await messagesService.deleteMessage(message.id)

            messages.value = messages.value.filter(
                item => item.id !== message.id
            )
        } catch (error) {
            console.error(error)

            errorMessage.value = t('adminMessages.deleteError')
        }
}


onMounted(() => {
    loadMessages()
})
</script>

<template>
    <div class="container-fluid py-4">

        <!-- Page title -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="h3 mb-1">
                    {{ t('adminMessages.title') }}
                </h1>

                <p class="text-muted mb-0">
                    {{ t('adminMessages.description') }}
                </p>
            </div>

            <span class="badge bg-primary fs-6">
                {{ messages.length }} {{ t('adminMessages.messagesCount') }}
            </span>

        </div>

        <!-- Error -->
        <div
            v-if="errorMessage"
            class="alert alert-danger"
        >
            {{ errorMessage }}
        </div>

        <!-- Loading -->
        <div
            v-if="loading"
            class="text-center py-5"
        >
            <div
                class="spinner-border text-primary"
                role="status"
            ></div>

            <p class="mt-2">
                {{ t('adminMessages.loading') }}
            </p>
        </div>

        <!-- No messages -->
        <div
            v-else-if="messages.length === 0"
            class="alert alert-info"
        >
            {{ t('adminMessages.noMessages') }}
        </div>

        <!-- Messages table -->
        <div
            v-else
            class="table-responsive"
        >
            <table class="table table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>{{ t('adminMessages.id') }}</th>
                        <th>{{ t('adminMessages.sender') }}</th>
                        <th>{{ t('adminMessages.email') }}</th>
                        <th>{{ t('adminMessages.subject') }}</th>
                        <th>{{ t('adminMessages.message') }}</th>
                        <th>{{ t('adminMessages.status') }}</th>
                        <th>{{ t('adminMessages.date') }}</th>
                        <th>{{ t('adminMessages.actions') }}</th>
                    </tr>
                </thead>

                <tbody>

                    <tr
                        v-for="message in messages"
                        :key="message.id"
                    >

                        <td>
                            {{ message.id }}
                        </td>

                        <td>
                            {{ message.name }}
                        </td>

                        <td>
                            {{ message.email }}
                        </td>

                        <td>
                            {{ message.subject }}
                        </td>

                        <td style="min-width: 250px;">
                            {{ message.message }}
                        </td>

                        <td>
                            <span
                                v-if="message.is_read"
                                class="badge bg-success"
                            >
                                {{ t('adminMessages.read') }}
                            </span>

                            <div v-else>
                                <div class="d-flex align-items-center">
                                <span class="badge bg-warning text-dark">
                                    {{ t('adminMessages.unread') }}
                                </span>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-success ms-2"
                                    @click="markAsRead(message)"
                                >
                                    {{ t('adminMessages.markAsRead') }}
                                </button>
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ formatDate(message.created_at) }}
                        </td>

                         <td>
                            <button
                                type="button"
                                class="btn btn-sm btn-outline-danger"
                                @click="deleteMessage(message)"
                            >
                                {{ t('adminMessages.delete') }}
                            </button>
                        </td>

                    </tr>

                </tbody>

            </table>
        </div>

    </div>
</template>