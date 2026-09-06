import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {

    state: () => ({
        user: JSON.parse(localStorage.getItem('user')) || null,
        token: localStorage.getItem('token') || null,
    }),

    getters: {

        isAuthenticated: (state) => !!state.token,

        isAdmin: (state) => state.user?.role === 'admin',

    },

    actions: {

        setAuth(user, token) {

            this.user = user
            this.token = token

            localStorage.setItem('token', token)
            localStorage.setItem('user', JSON.stringify(user))

        },
       /* that was if the avatar disappears when the refersh happens 
       updateUser(user) {

            this.user = user

            localStorage.setItem('user', JSON.stringify(user))

        },
       */
        logout() {

            this.user = null
            this.token = null

            localStorage.removeItem('token')
            localStorage.removeItem('user')
        }

    }

})