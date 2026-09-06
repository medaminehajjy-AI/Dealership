<template>

  <div class="d-flex justify-content-between align-items-center mb-2">

  <div>

    <h1>{{ t('adminCustomers.title') }}</h1>

    <p class="text-muted mb-0">
        {{ t('adminCustomers.description') }}
    </p>

  </div>

</div>


<!-- Customer Statistics -->

<div class="row mb-4">

  <div class="col-md-4">

    <div class="card shadow-sm">

      <div class="card-body">

        <div class="text-muted">
            {{ t('adminCustomers.totalCustomers') }}
        </div>

        <h2 class="fw-bold mb-0">
          {{ customers.length }}
        </h2>

      </div>

    </div>

  </div>

</div>


    <!-- Loading -->
    <div
      v-if="loading"
      class="text-center py-5"
    >

      <div class="spinner-border text-primary"></div>

      <p class="mt-3">
          {{ t('adminCustomers.loading') }}
      </p>

    </div>


    <!-- Error -->
    <div
      v-else-if="error"
      class="alert alert-danger"
    >
      {{ error }}
    </div>


    <!-- Customers -->
    <div
      v-else
      class="card shadow-sm"
    >

      <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

          <thead class="table-light">

            <tr>

              <th>{{ t('adminCustomers.id') }}</th>
              <th>{{ t('adminCustomers.name') }}</th>
              <th>{{ t('adminCustomers.email') }}</th>
              <th>{{ t('adminCustomers.role') }}</th>
              <th>{{ t('adminCustomers.registered') }}</th>
              <th>{{ t('adminCustomers.actions') }}</th>

            </tr>

          </thead>


          <tbody>

            <!-- Customers exist -->
            <tr
              v-for="customer in customers"
              :key="customer.id"
            >

              <td>
                {{ customer.id }}
              </td>

              <td>
                <strong>
                  {{ customer.name }}
                </strong>
              </td>

              <td>
                {{ customer.email }}
              </td>

              <td>

                <span class="badge bg-primary">
                  {{ customer.role }}
                </span>

              </td>

              <td>
                {{ formatDate(customer.created_at) }}
              </td>

              <td>

                    <button
                        class="btn btn-sm btn-danger"
                        @click="deleteCustomer(customer.id)"
                    >
                        <i class="bi bi-trash"></i>
                        {{ t('adminCustomers.delete') }}
                    </button>
              </td>

            </tr>


            <!-- No customers -->
            <tr v-if="customers.length === 0">

              <td
                  colspan="6"
                  class="text-center text-muted py-4"
              >
                  {{ t('adminCustomers.noCustomers') }}
              </td>

            </tr>

          </tbody>

        </table>

      </div>

    </div>


</template>


<script setup>

import { ref, onMounted } from 'vue'
import customersService from '../../services/customers'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const customers = ref([])
const loading = ref(true)
const error = ref(null)


const loadCustomers = async () => {

  try {

    const response =
      await customersService.getCustomers()

    customers.value =
      response.data.customers

  } catch (err) {

    console.error(err)

    error.value = err.response?.data?.message || t('adminCustomers.loadError')

  } finally {

    loading.value = false

  }

}
const formatDate = (date) => {

  if (!date) {
    return '-'
  }

  return new Date(date).toLocaleDateString()

}

const deleteCustomer = async (id) => {

        const confirmed = confirm(
            t('adminCustomers.deleteConfirmation')
        )

        if (!confirmed) {
            return
        }

        try {

            await customersService.deleteCustomer(id)

            await loadCustomers()

        } catch (err) {

            console.error(err)

            alert( err.response?.data?.message || t('adminCustomers.deleteError') )

        }

}



onMounted(() => {

  loadCustomers()

})

</script>