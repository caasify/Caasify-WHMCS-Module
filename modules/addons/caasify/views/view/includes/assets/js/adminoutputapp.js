const { createApp } = Vue

app = createApp({

    data() {
        return {
            // mr
            activeTab: 'transactions',
            addPromotion : {
                typeSignArea: '%' ,
                userListSectionDisplay: false ,
                isDisabled : false,
                form : {
                    promotion_code : '',
                    type : 'percent',
                    value : '',
                    start_date : '',
                    expiration_date : '',
                    max_use : '0',
                    user_type : 'all_users',
                    user_list : [],
                    recurring_no : '1',
                    min_amount : '0',
                    max_amount : '0',
                },
                alert : {
                    show : false,
                    type : 'error',
                    message : 'Test ast',
                },
            },
            editPromotion : {
                typeSignArea: '%' ,
                loading: false ,
                isDisabled : false,
                form : {
                    id : '',
                    promotion_code : '',
                    type : 'percent',
                    value : '',
                    start_date : '',
                    expiration_date : '',
                    max_use : '0',
                    user_type : 'all_users',
                    user_list : [],
                    recurring_no : '1',
                    min_amount : '0',
                    max_amount : '0',
                },
                alert : {
                    show : false,
                    type : 'error',
                    message : 'Test ast',
                },
            },
            promotionList : {
                allowedUser : {
                    isLoading : false,
                    data : {
                        code : '',
                        list : [],
                    }
                },
                usedDetail : {
                    isLoading : false,
                    data : {
                        code : '',
                        list : [],
                    }
                },
            },
            // other
            configIsLoaded: false,
            CaasifyConfigs: null,

        }
    },
    
    mounted() {
        this.fetchModuleConfig()
        this.$nextTick(() => {
            const hash = window.location.hash.replace("#", "");
            if (hash) {
                this.activeTab = hash;
                // alert(`Hash found: ${hash}`);
            } else {
                // alert("No hash found in URL");
            }
        });
    },

    watch: {
        configIsLoaded(newValue){
            if(newValue == true){
                //this.addPromotionCode()
            }
        }
    },

    computed: {
        
    },

    methods: {

        generateRandomCode() {
            const prefix = "CAAS-";
            const length = 9;
            const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            let randomCode = "";

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                randomCode += characters[randomIndex];
            }

            this.addPromotion.form.promotion_code = prefix + randomCode;
        },

        generateRandomCodeEdit() {
            const prefix = "CAAS-";
            const length = 9;
            const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            let randomCode = "";

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                randomCode += characters[randomIndex];
            }

            this.editPromotion.form.promotion_code = prefix + randomCode;
        },

        promotionTypeOnChange(){
            const value = this.$refs.type.value;
            if(value == "percent"){
                this.addPromotion.typeSignArea = "%";
            }
            else {
                this.addPromotion.typeSignArea = "€";
            }
        },
        promotionTypeOnChangeEdit(){
            const value = this.editPromotion.form.type;
            if(value == "percent"){
                this.editPromotion.typeSignArea = "%";
            }
            else {
                this.editPromotion.typeSignArea = "€";
            }
        },

        userTypeOnChange(){
            const userType = this.$refs.userType.value;

            if(userType === "specific_users")
                this.addPromotion.userListSectionDisplay = true;
            else
                this.addPromotion.userListSectionDisplay = false;

        },

        fetchModuleConfig() {
            this.configIsLoaded = false
            fetch('configApi.php')  // Use a relative path to reference the PHP file
                .then(response => response.json())
                .then(data => {
                    this.configIsLoaded = true
                    this.CaasifyConfigs = data.configs;
                })
                .catch(error => {
                    this.configIsLoaded = true
                    console.error('Error fetching Config API');
                });
        },

        // admin/index?adminuotputaction=admin_addPromotionCode
        CreateRequestLink(action) {
            let adminoutput = this.CaasifyConfigs.AdminClientsSummaryLink;
            const url = new URL(adminoutput);
            const pathSegments = url.pathname.split('/');
            const rootAddress = `${url.origin}/${pathSegments[1]}`;

            if(rootAddress == null){
                rootAddress = '/admin/index.php';
            }

            let RequestLink = rootAddress + '/admin/index.php?m=caasify&adminuotputaction=' + action;
            return RequestLink;
        },

        
        async addPromotionCode() {
            this.addPromotionHideAlert();
            this.addPromotion.isDisabled = true;

            RequestLink = this.CreateRequestLink(action = 'admin_addPromotionCode');
            if(RequestLink == null){
                console.error('addPromotionCode: Creating the link cause error');
                return 'addPromotionCode: Creating the link cause error'
            }

            //console.log(this.addPromotion.form);
            let response = await axios.post(RequestLink , this.addPromotion.form)
                .then((response) => {
                    response = response.data;
                    //console.log(response);
                    if(response.status === false){
                        this.addPromotionErrorAlert(response.msg);
                        this.addPromotion.isDisabled = false;
                    }else {
                        this.addPromotionSuccessAlert(response.msg);
                        this.addPromotionResetForm();
                        this.addPromotion.isDisabled = false;
                        this.reloadWithParams();
                    }
                })
                .catch((error)=> {
                    console.error(error);
                    this.addPromotionSuccessAlert("Exception accrued");
                    this.addPromotion.isDisabled = false;
                });
        },

        addPromotionErrorAlert(msg){
            this.addPromotion.alert.type = "error";
            this.addPromotion.alert.message = msg;
            this.addPromotion.alert.show = true;
        },
        addPromotionSuccessAlert(msg){
            this.addPromotion.alert.type = "success";
            this.addPromotion.alert.message = msg;
            this.addPromotion.alert.show = true;
        },
        addPromotionHideAlert(){
            this.addPromotion.alert.show = false;
        },
        addPromotionResetForm(){
            this.addPromotion.form = {
                promotion_code : '',
                    id : '',
                    type : 'percent',
                    value : '',
                    start_date : '',
                    expiration_date : '',
                    max_use : '0',
                    user_type : 'all_users',
                    user_list : [],
                    recurring_no : '1',
                    min_amount : '0',
                    max_amount : '0',
            };
        },
        async deactivatePromotionCode(id){

            RequestLink = this.CreateRequestLink(action = 'deactivatePromotionCode');
            if(RequestLink == null){
                console.error('deactivatePromotionCode: Creating the link cause error');
                return 'deactivatePromotionCode: Creating the link cause error'
            }

            let response = await axios.post(RequestLink , {id : id})
                .then((response) => {
                    response = response.data;
                    if(response.status === false){
                    }else {
                        // alert("Promotion Deactivated successfully")
                        // window.location.reload();
                        this.reloadWithParams();
                    }
                })
                .catch((error)=> {
                    console.error(error);
                });
        },
        async activatePromotionCode(id){

            RequestLink = this.CreateRequestLink(action = 'activatePromotionCode');
            if(RequestLink == null){
                console.error('activatePromotionCode: Creating the link cause error');
                return 'activatePromotionCode: Creating the link cause error'
            }

            let response = await axios.post(RequestLink , {id : id})
                .then((response) => {
                    response = response.data;
                    if(response.status === false){
                    }else {
                        // alert("Promotion Activated successfully")
                        // window.location.reload();
                        this.reloadWithParams();
                    }
                })
                .catch((error)=> {
                    console.error(error);
                });
        },
        async getAllowedUserList(promotionId , code){

            this.promotionList.allowedUser.isLoading = true;
            this.promotionList.allowedUser.data.code = code;

            RequestLink = this.CreateRequestLink(action = 'getAllowedUserList');
            if(RequestLink == null){
                console.error('getAllowedUserList: Creating the link cause error');
                return 'getAllowedUserList: Creating the link cause error'
            }

            let response = await axios.post(RequestLink , {id : promotionId})
                .then((response) => {

                    response = response.data;

                    if(response.status === false){

                        console.error(response);
                        this.promotionList.allowedUser.isLoading = false;

                    }else {
                        this.promotionList.allowedUser.data.list = response.data;
                        this.promotionList.allowedUser.isLoading = false;
                    }
                })
                .catch((error)=> {
                    console.error(error);
                });


        },
        async getUsedDetail(promotionId , code){
            this.promotionList.usedDetail.isLoading = true;
            this.promotionList.usedDetail.data.code = code;

            RequestLink = this.CreateRequestLink(action = 'getUsedDetail');
            if(RequestLink == null){
                console.error('getAllowedUserList: Creating the link cause error');
                return 'getAllowedUserList: Creating the link cause error'
            }

            let response = await axios.post(RequestLink , {id : promotionId})
                .then((response) => {

                    response = response.data;

                    if(response.status === false){

                        console.error(response);
                        this.promotionList.usedDetail.data.list = response.data;
                        this.promotionList.usedDetail.isLoading = false;

                    }else {
                        this.promotionList.usedDetail.data.list = response.data;
                        this.promotionList.usedDetail.isLoading = false;
                    }
                })
                .catch((error)=> {
                    console.error(error);
                });

        },

        async editPromotionButton(promotionId , code){
            this.editPromotion.loading = true;

            RequestLink = this.CreateRequestLink(action = 'getPromotionDetail');
            if(RequestLink == null){
                console.error('getAllowedUserList: Creating the link cause error');
                return 'getAllowedUserList: Creating the link cause error'
            }

            let response = await axios.post(RequestLink , {id : promotionId})
                .then((response) => {

                    response = response.data;

                    if(response.status === false){

                        console.error(response);
                        this.editPromotion.loading = false;

                    }else {
                        console.log(response)
                        this.editPromotion.form = response.data;

                        if(this.editPromotion.form.type === "percent")
                            this.editPromotion.typeSignArea = "%";
                        else
                            this.editPromotion.typeSignArea = "€";

                        this.editPromotion.form.promotion_code = this.editPromotion.form.code;
                        this.editPromotion.loading = false;

                        this.$nextTick(() => {
                            $('.selectpicker').selectpicker("refresh");
                        });
                    }
                })
                .catch((error)=> {
                    console.error(error);
                });

        },
        async editPromotionCode() {
            this.editPromotionHideAlert();
            this.editPromotion.isDisabled = true;

            RequestLink = this.CreateRequestLink(action = 'admin_editPromotionCode');
            if(RequestLink == null){
                console.error('editPromotion: Creating the link cause error');
                return 'editPromotion: Creating the link cause error'
            }

            //console.log(this.editPromotion.form);
            let response = await axios.post(RequestLink , this.editPromotion.form)
                .then((response) => {
                    response = response.data;
                    //console.log(response);
                    if(response.status === false){
                        this.editPromotionErrorAlert(response.msg);
                        this.editPromotion.isDisabled = false;
                    }else {
                        this.editPromotionSuccessAlert(response.msg);
                        this.editPromotion.isDisabled = false;
                        this.reloadWithParams();
                    }
                })
                .catch((error)=> {
                    console.error(error);
                    this.editPromotionSuccessAlert("Exception accrued");
                    this.editPromotion.isDisabled = false;
                });
        },
        editPromotionErrorAlert(msg){
            this.editPromotion.alert.type = "error";
            this.editPromotion.alert.message = msg;
            this.editPromotion.alert.show = true;
        },
        editPromotionSuccessAlert(msg){
            this.editPromotion.alert.type = "success";
            this.editPromotion.alert.message = msg;
            this.editPromotion.alert.show = true;
        },
        editPromotionHideAlert(){
            this.editPromotion.alert.show = false;
        },
        reloadWithParams() {
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('section' , 'promotion' + Date.now());
            currentUrl.hash = 'promotion';

            window.location.href = currentUrl.toString();
        }
    }
});


app.mount('.adminoutputapp') 