const { createApp } = Vue

app = createApp({

    data() {
        return {
            name: 'Caasify',
            localVersion: null,
            latestVersion: null,

            invoices: [],

            gifts: [],
            giftForm: {},
            giftFormError: null,

            isCreating: false,
            isDeleting: false,

            isUpdating: false,
            isUpdatingPermission: false,

            systemUrl: null
        }
    },

    mounted() {
        this.loadSystemUrl()
        this.loadLocalVersion()
        this.loadLatestVersion()

        this.loadInvoices()

        this.loadGifts()
    },

    methods: {
        async loadLocalVersion() {
        
            let response = await axios.get(this.systemUrl + '/caasify.php?action=localVersion')

            response = response.data

            if (response?.version) {
                this.localVersion = response.version
            }

            if (response?.message) {
                alert(response.message)
            }
        },

        async loadLatestVersion() {
        
            let response = await axios.get(this.systemUrl + '/caasify.php?action=latestVersion')

            response = response.data

            if (response?.version) {
                this.latestVersion = response.version
            }

            if (response?.message) {
                alert(response.message)
            }
        },

        async loadGifts() {
        
            let response = await axios.get(this.systemUrl + '/caasify.php?action=gifts')

            response = response.data

            if (response?.data) {
                this.gifts = response.data
            }
        },

        async createGift() {
        
            this.isCreating = true

            let response = await axios.post(this.systemUrl + '/caasify.php?action=createGift', this.giftForm)

            response = response.data

            if (response?.message) {
                this.giftFormError = response.message
            }

            if (response?.data) {
                window.location.reload();
            }

            this.isCreating = false
        },

        async deleteGift(id) {

            this.isDeleting = true

            let response = await axios.post(this.systemUrl + '/caasify.php?action=deleteGift', {id})

            response = response.data
            
            if (response?.message) {
                this.giftFormError = response.message
            }

            if (response?.data) {
                window.location.reload();
            }

            this.isDeleting = false
        },

        async loadInvoices() {
        
            let response = await axios.get(this.systemUrl + '/caasify.php?action=invoices')

            response = response.data

            if (response?.data) {
                this.invoices = response.data
            }
        },

        isPaid(invoice) {

            if (invoice?.invoice_status == 'Paid') {
                return true
            }

            return false
        },

        isCompleted(invoice) {

            if (invoice?.transactionid) {
                return true
            }

            return false
        },

        async updateModule() {

            this.isUpdating = true
        
            let response = await axios.get(this.systemUrl + '/caasify.php?action=update')

            response = response.data

            if (response?.message) {
                alert(response.message)
            }

            this.isUpdating = false
        },

        async updatePermission() {

            this.isUpdatingPermission = true
        
            let response = await axios.get(this.systemUrl + '/caasify.php?action=permission')

            response = response.data

            if (response?.message) {
                alert(response.message)
            }

            this.isUpdatingPermission = false
        },

        async loadSystemUrl() {

            const query = new URLSearchParams(window.location.search)

            this.systemUrl = query.get('systemUrl');
        }
    }
})

app.mount('#app') 