import api from './api'

export default {
  
  /* Get all cars with optional query parameters, this for the user section */
  getCars(params = {}) {
      return api.get('/cars', {  params: params })
  },
  /* this get cars for the admin cars management in order to apply pagination */
  getAdminCars(params = {}) {
    return api.get('/admin/cars', { params: params })
  },
  /* this is for the Carousel */
  getLatestCars() {
    return api.get('/cars/latest')
  },

  getCar(id) {
    return api.get(`/cars/${id}`)
  },

  addFavorite(carId) {
    return api.post(`/cars/${carId}/favorite`)
  },

  removeFavorite(carId) {
    return api.delete(`/cars/${carId}/favorite`)
  },

  checkFavorite(carId) {
    return api.get(`/cars/${carId}/favorite`)
  },

  getFavorites() {
    return api.get('/favorites')
  },

  submitPurchaseRequest(carId, message) {
    return api.post(`/cars/${carId}/purchase-request`, {
      message: message,
    })
  },
  getPurchaseRequests() {
    return api.get('/purchase-requests')
  },

  getAdminPurchaseRequests() {
    return api.get('/admin/purchase-requests')
  },

  updatePurchaseRequestStatus(id, status) {
    return api.patch(`/admin/purchase-requests/${id}`, {
      status: status,
    })
  },

  getAdminDashboard() {
    return api.get('/admin/dashboard')
  },

  getAdminStatistics() {
    return api.get('/admin/statistics')
  },

  /* Create Car*/ 
  createCar(carData) {
    return api.post('/admin/cars', carData)
  },
  getBrands() {
    return api.get('/brands')
  },

  getCategories() {
    return api.get('/categories')
  },
  /* Edit Car*/ 
  getAdminCar(id) {
    return api.get(`/admin/cars/${id}`)
  },

  updateCar(id, carData) {
      return api.put(`/admin/cars/${id}`, carData)
  },
  deleteCar(id) {
      return api.delete(`/admin/cars/${id}`)
  },
  uploadCarImage(id, imageFile) {
      const formData = new FormData()

      formData.append('image', imageFile)

      return api.post(`/admin/cars/${id}/images`, formData)
  },

  deleteCarImage(id) {
      return api.delete(`/admin/car-images/${id}`)
  },
  
 


}