<template>
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">{{ t('adminBookings.title') }}</h2>
                <p class="text-muted mb-0">
                    {{ t('adminBookings.description') }}
                </p>
            </div>
        </div>

        <!-- Loading -->
        <div v-if="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">{{ t('adminBookings.loading') }}</span>
            </div>

            <p class="mt-2 text-muted">
                {{ t('adminBookings.loading') }}
            </p>
        </div>

        <!-- Error -->
        <div v-else-if="error" class="alert alert-danger">
            {{ error }}
        </div>

        <!-- No bookings -->
        <div v-else-if="bookings.length === 0" class="alert alert-info">
            {{ t('adminBookings.noBookings') }}
        </div>

        <!-- Bookings table -->
        <div v-else class="card shadow-sm">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>{{ t('adminBookings.id') }}</th>
                                <th>{{ t('adminBookings.customer') }}</th>
                                <th>{{ t('adminBookings.car') }}</th>
                                <th>{{ t('adminBookings.date') }}</th>
                                <th>{{ t('adminBookings.time') }}</th>
                                <th>{{ t('adminBookings.message') }}</th>
                                <th>{{ t('adminBookings.status') }}</th>
                                <th>{{ t('adminBookings.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="booking in bookings"
                                :key="booking.id"
                            >
                                <td>
                                    #{{ booking.id }}
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ booking.user?.name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ booking.user?.email }}
                                    </small>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ booking.car?.brand?.name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ booking.car?.model }}
                                    </small>
                                </td>

                                <td>
                                    {{ booking.booking_date }}
                                </td>

                                <td>
                                    {{ booking.booking_time }}
                                </td>

                                <td>
                                    <span v-if="booking.message">
                                        {{ booking.message }}
                                    </span>

                                    <span v-else class="text-muted">
                                        {{ t('adminBookings.noMessage') }}
                                    </span>
                                </td>

                                <td>
                                    <span
                                        class="badge"
                                        :class="statusClass(booking.status)"
                                    >
                                        {{ statusLabel(booking.status) }}
                                    </span>
                                </td>
                                
                                <td>
                                    <div v-if="booking.status === 'pending'" class="d-flex gap-2">

                                        <button
                                            class="btn btn-sm btn-success"
                                            :disabled="updatingBookingId === booking.id"
                                            @click="updateStatus(booking.id, 'confirmed')"
                                        >
                                            <span
                                                v-if="updatingBookingId === booking.id"
                                                class="spinner-border spinner-border-sm me-1"
                                                role="status"
                                            ></span>

                                            {{ t('adminBookings.confirm') }}
                                        </button>

                                        <button
                                            class="btn btn-sm btn-danger"
                                            :disabled="updatingBookingId === booking.id"
                                            @click="confirmCancellation(booking.id)"
                                        >
                                            {{ t('adminBookings.cancel') }}
                                        </button>

                                    </div>

                                    <span v-else class="text-muted">
                                        {{ t('adminBookings.noActions') }}
                                    </span>
                                </td>

                            </tr>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import bookingsService from '@/services/bookings'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const bookings = ref([])
const loading = ref(false)
const error = ref('')
const updatingBookingId = ref(null)


const fetchBookings = async () => {
    loading.value = true
    error.value = ''

    try {
        const response = await bookingsService.getAdminBookings()

        bookings.value = response.data.bookings
    } catch (err) {
        console.error('Failed to load bookings:', err)

        error.value = t('adminBookings.error')
    } finally {
        loading.value = false
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'pending':
            return 'bg-warning text-dark'

        case 'confirmed':
            return 'bg-success'

        case 'cancelled':
            return 'bg-danger'

        default:
            return 'bg-secondary'
    }
}
/* this function just for translation */
const statusLabel = (status) => {
    switch (status) {
        case 'pending':
            return t('adminBookings.pending')

        case 'confirmed':
            return t('adminBookings.confirmed')

        case 'cancelled':
            return t('adminBookings.cancelled')

        default:
            return status
    }
}

const updateStatus = async (bookingId, status) => {
        updatingBookingId.value = bookingId

        try {
            const response = await bookingsService.updateBookingStatus(
                bookingId,
                status
            )

            const updatedBooking = response.data.booking

            const index = bookings.value.findIndex(
                booking => booking.id === bookingId
            )

            if (index !== -1) {
                bookings.value[index] = updatedBooking
            }
        } catch (err) {
            console.error('Failed to update booking status:', err)

            error.value = t('adminBookings.updateError')
        } finally {
            updatingBookingId.value = null
        }
}

const confirmCancellation = (bookingId) => {
    const confirmed = window.confirm(
            t('adminBookings.cancelConfirmation')
        )

    if (confirmed) {
        updateStatus(bookingId, 'cancelled')
    }
}


onMounted(() => {
    fetchBookings()
})
</script>