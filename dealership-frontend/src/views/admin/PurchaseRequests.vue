<template>
  <div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1>{{ t('adminPurchaseRequests.title') }}</h1>
        <p class="text-muted">
            {{ t('adminPurchaseRequests.description') }}
        </p>
      </div>

      <span class="badge bg-primary fs-6">
          {{ requests.length }} {{ t('adminPurchaseRequests.requestsCount') }}
      </span>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary"></div>
      <p class="mt-3">
          {{ t('adminPurchaseRequests.loading') }}
      </p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- Empty -->
    <div
    v-else-if="requests.length === 0"
    class="alert alert-info"
    >
        {{ t('adminPurchaseRequests.noRequests') }}
    </div>

    <!-- Requests table -->
    <div v-else class="card shadow-sm">

      <div class="card-body p-0">

        <div class="table-responsive">

          <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>{{ t('adminPurchaseRequests.customer') }}</th>
                <th>{{ t('adminPurchaseRequests.car') }}</th>
                <th>{{ t('adminPurchaseRequests.message') }}</th>
                <th>{{ t('adminPurchaseRequests.status') }}</th>
                <th>{{ t('adminPurchaseRequests.date') }}</th>
                <th>{{ t('adminPurchaseRequests.actions') }}</th>
              </tr>
            </thead>

            <tbody>

              <tr
                v-for="request in requests"
                :key="request.id"
              >

                <td>
                  {{ request.id }}
                </td>

                <td>
                  <strong>
                    {{ request.user?.name }}
                  </strong>

                  <br>

                  <small class="text-muted">
                    {{ request.user?.email }}
                  </small>
                </td>

                <td>
                  <strong>
                    {{ request.car?.brand?.name }}
                    {{ request.car?.model }}
                  </strong>

                  <br>

                  <small class="text-muted">
                    {{ request.car?.year }}
                  </small>
                </td>

                <td>
                  <span v-if="request.message">
                    {{ request.message }}
                  </span>

                  <span
                      v-else
                      class="text-muted"
                  >
                      {{ t('adminPurchaseRequests.noMessage') }}
                  </span>
                </td>

                <td>

                  <span
                    class="badge"
                    :class="statusClass(request.status)"
                  >
                    {{ statusLabel(request.status) }}
                  </span>

                </td>

                <td>
                  {{ formatDate(request.created_at) }}
                </td>

                <td>
                  <div class="d-flex gap-2">

                    <!-- Approve -->
                    <button
                      v-if="request.status === 'pending'"
                      class="btn btn-sm btn-success"
                      @click="updateStatus(request.id, 'approved')"
                      :disabled="actionLoading === request.id"
                    >
                      {{ t('adminPurchaseRequests.approve') }}
                    </button>

                    <!-- Reject -->
                    <button
                      v-if="request.status === 'pending'"
                      class="btn btn-sm btn-danger"
                      @click="updateStatus(request.id, 'rejected')"
                      :disabled="actionLoading === request.id"
                    >
                      {{ t('adminPurchaseRequests.reject') }}
                    </button>

                    <!-- Complete Sale -->
                    <button
                      v-if="request.status === 'approved'"
                      class="btn btn-sm btn-primary"
                      @click="updateStatus(request.id, 'completed')"
                      :disabled="actionLoading === request.id"
                    >
                      {{ t('adminPurchaseRequests.completeSale') }}
                    </button>

                  </div>
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
import carsService from '../../services/cars'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const requests = ref([])
const loading = ref(true)
const error = ref(null)
const actionLoading = ref(null)

const loadRequests = async () => {
  try {
    const response = await carsService.getAdminPurchaseRequests()

    requests.value = response.data.purchase_requests

  } catch (err) {
    error.value = t('adminPurchaseRequests.error')
  } finally {
    loading.value = false
  }
}

const statusClass = (status) => {
  if (status === 'pending') {
    return 'bg-warning text-dark'
  }

  if (status === 'approved') {
    return 'bg-success'
  }

  if (status === 'rejected') {
    return 'bg-danger'
  }

  if (status === 'completed') {
    return 'bg-primary'
  }

  return 'bg-secondary'
}
/* this function just for translation */
const statusLabel = (status) => {
    switch (status) {
        case 'pending':
            return t('adminPurchaseRequests.pending')

        case 'approved':
            return t('adminPurchaseRequests.approved')

        case 'rejected':
            return t('adminPurchaseRequests.rejected')

        case 'completed':
            return t('adminPurchaseRequests.completed')

        default:
            return status
    }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString()
}

const updateStatus = async (id, status) => {
      actionLoading.value = id

      try {
        const response = await carsService.updatePurchaseRequestStatus(
          id,
          status
        )

        const updatedRequest = response.data.purchase_request

        const index = requests.value.findIndex(
          request => request.id === id
        )

        if (index !== -1) {
          requests.value[index] = {
            ...requests.value[index],
            status: updatedRequest.status,
          }
        }

      } catch (err) {
        alert(t('adminPurchaseRequests.updateError'))
      } finally {
        actionLoading.value = null
      }
    }

onMounted(() => {
  loadRequests()
})
</script>