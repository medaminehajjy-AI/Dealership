import api from './api'

const customersService = {

    getCustomers() {
        return api.get('/admin/customers')
    },

    deleteCustomer(id) {
        return api.delete(`/admin/customers/${id}`)
    }



}

export default customersService