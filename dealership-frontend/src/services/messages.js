import api from './api'

const messagesService = {


    getMessages() {
        return api.get('/admin/messages')
    },

    markAsRead(id) {
        return api.patch(`/admin/messages/${id}/read`)
    },

    deleteMessage(id) {
        return api.delete(`/admin/messages/${id}`)
    },


}

export default messagesService