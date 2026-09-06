 import api from './api'

export default {
 
 submitBooking(id, bookingData) {
      return api.post(`/cars/${id}/booking`, bookingData)
  },

  getAdminBookings() {
        return api.get('/admin/bookings')
  },

 updateBookingStatus(bookingId, status) {
        return api.patch(`/admin/bookings/${bookingId}`, {
            status: status
        })
    },

}