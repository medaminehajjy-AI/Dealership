import api from './api'

export default {

    register(data) {
        return api.post('/register', data)
    },

    login(data) {
        return api.post('/login', data)
    },

    logout() {
        return api.post('/logout')
    },

    getUser() {
        return api.get('/user')
    }

}