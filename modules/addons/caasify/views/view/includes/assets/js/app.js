const { createApp } = Vue

app = createApp({

    data() {
        return {
            favoritPlans: [],
            isFirstRequest: true,
            noNeedToRecom: true,
            recomPlansAreLoaded: false,
            recomPlansAreLoading: true,
            noRecomPlanToShow: false,
            recomPlans: [],

            checkBoxesStatus: {},
            onlyUnlimitedTrafficCheckbox: false,
            noPlanToShow: false,
            selectedTremsWithType : {},
            selectedRanges: {"CPU":"1","Disk":"10","Ram":"1","Traffic":"0"},
            opacity: 0.1,
            increasing: true,

            selectedTerms: {},
            FilterTermsAreLoaded: false,
            FilterTermsIsNull: false,
            FilterTermsLength: null,
            FilterTerms: {},

            expenseDatesIsLoaded: false,
            expenseDatesMessage: null,
            ExpensesMessage: null,
            expenseDates: null,
            SelectedExpenseDate: null,
            expenses: {},
            expensesAreLoaded: false,

            parentCategories: 
                [ 
                    { name : this.lang('Virtual Machine'), icon: this.createIconAddr('vm.png') },
                    { name : this.lang('Kubernetes As A Service'), icon: this.createIconAddr('kubernetes.png') },
                    { name : this.lang('AI GPU'), icon: this.createIconAddr('aigpu.png') },
                    { name : this.lang('Database As A Service'), icon: this.createIconAddr('database.png') },
                    // {name : 'S3 Storage', icon: this.createIconAddr('storage.png') },
                ],
            SelectedCategory: null,

            newMachineCreated: null,
            NewMcahineCreatedViewLink: null,

            // new Charging sys
            InvoiceCreationStatus: null,
            SelectedGetway: 'mailin',
            popupMessage: null,
            WaitForConsoleRoute: false,
            ConsoleTimer: null,
            latestConsoleRequestId: null,
            endLoadHistoryForConsole: false,
            
            // Mycaasify
            ResellerChargeAmount: null,
            ConstResellerChargeAmount: null,
            userLoadStatus: null,
            usertoken: null,
            showToken: false,
            maskedToken: '**********',
            BtnCopyTokenPushed: false,

            CaasifyResellerUserIsLoaded: false,
            CaasifyResellerUserInfo: null,

            ChargeMSG: '',
            configIsLoaded: false,

            thisOrderTraffic: null,
            trafficsIsLoaded: false,
            TrafficInbound: false,
            TrafficOutbound: false,
            TrafficTotal: false,

            CaasifyUserIsNull: null,
            WhmcsUserIsNull: null,
            DataCenterIsNull: null,


            config: {
                MinimumCharge: null,
                MaximumCharge: null,
                MinBalanceAllowToCreate: null,
                MonthlyCostDecimal: null,
                HourlyCostDecimal: null,
                BalanceDecimal: null,
                DemoMode: null,
                Commission: null,
            },

            // views
            orderID: null,
            thisProduct: null,
            thisOrder: null,
            ordeIsLoaded: null,

            views: null,
            viewsAreLoading: null,
            viewsAreLoaded: null,
            ValidViewItems: null,
            NoValidViewItems: null,

            NewViewStatus: null,

            Controllers: null,
            ValidControllerItems: null,
            ControllersAreLoading: true,
            NoValidControllerItems: null,

            actionWouldBeHappened: null,
            ActionAlert: null,
            ActionAlertStatus: null,
            ActionHistory: null,
            ActionHistoryIsLoaded: null,

            PassVisible: false,

            // Generals
            fileName: null,
            PanelLanguage: null,
            WhmcsCurrencies: null,
            userCreditinWhmcs: null,
            userCurrencyIdFromWhmcs: null,
            CaasifyConfigs: [],
            systemUrl: null,
            BackendUrl: null,
            CaasifyUserInfo: null,
            WhmcsUserInfo: null,

            // index
            OrdersLoaded: false,

            user: {},
            UserOrders: [],
            userHasNoOrder: false,
            ConstUserId: null,

            chargeAmountinWhmcs: null,
            ConstChargeamountInWhmcs: null,
            chargeAmountAdminInput: null,
            invoice: null,
            invoiceId: null,
            ConstantInvoiceId: null,

            AdminTransSuccess: null,
            adminTransId: null,
            AdminClickOnTrans: null,
            theChargingSteps: 0,
            theStepStatus: 0,
            TransactionError: null,
            GlobalError: null,

            // Create
            PanelLanguage: null,
            moduleConfig: null,
            moduleConfigIsLoaded: null,

            checkboxconfirmation: null,
            checkboxSPOTconfirmation: null,
            CreateMSG: null,
            RullesText: null,

            DataCenters: [],
            SelectedDataCenter: null,
            DataCentersAreLoaded: false,
            DataCentersLength: 0,

            regions: [],
            SelectedRegion: null,

            plans: [],
            SelectedPlan: null,
            plansAreLoaded: false,
            plansAreLoading: true,
            
            

            PlanSections: null,
            PlanConfigSelectedOptions: {},


            confirmDialog: false,
            confirmTitle: null,
            confirmText: null,

            messageDialog: false,
            messageText: null,

            themachinename: null,
            MachineNameValidationError: false,
            SshNameValidationError: false,
            MachineNamePreviousValue: "",
            SshNamePreviousValue: "",

            themachinessh: null,

            createActionFailed: false,
            createActionSucced: false,
            createActionIsInQueue: false,
            userClickedCreationBtn: false,
            CreateIsLoading: false,
            showAlertModal: false,            
            CLBlanaceChecked: false,

        } 
    },

    watch: {
        onlyUnlimitedTrafficCheckbox(newValue){
            if(newValue == true){
                let id = this.findUnlimitedTrafficId()
                if(id != false){
                    this.selectedTremsWithType['Traffic'] = id
                }
                this.selectedRanges['Traffic'] = '0'
                const trafficRange = document.getElementById('Traffic');
                this.ColorizeRange({ target: trafficRange }, 'Traffic');

            } else { 
                let id = this.findUnlimitedTrafficId()
                if(this.selectedTremsWithType['Traffic'] == id){
                    this.selectedTremsWithType['Traffic'] = undefined
                }
                const trafficRange = document.getElementById('Traffic');
                this.ColorizeRange({ target: trafficRange }, 'Traffic');
            }
        },

        selectedTremsWithType: {
            handler(newValue, oldValue) {
                let id = this.findUnlimitedTrafficId()
                if(id != false){
                    if(newValue['Traffic'] !== id){
                        this.onlyUnlimitedTrafficCheckbox = false
                    }
                }

                let allTermsValueFormBasicFilter = {}
                this.FilterTerms.forEach(filters => {
                    if(filters.name == 'CPU' || filters.name == 'Ram' || filters.name == 'Disk' || filters.name == 'Traffic'){
                        if (!allTermsValueFormBasicFilter[filters.name]) {
                            allTermsValueFormBasicFilter[filters.name] = [];
                        }
                        filters.terms.forEach(terms => {
                            allTermsValueFormBasicFilter[filters.name].push(terms.id)
                        });
                    }                    
                });

                // clear old value if Exist
                for (let type in newValue) {
                    if (newValue[type] === undefined || (Array.isArray(newValue[type]) && newValue[type]?.length === 0)) {
                        this.selectedTerms[type] = []
                    }                    
                }

                // fill again new value 
                for (let key in newValue) {
                    if(newValue[key]){
                        if(!this.selectedTerms[key]){
                            this.selectedTerms[key] = []
                        }
                        this.selectedTerms[key] = newValue[key]
                    }
                } 

                this.selectedTermsSave()
                this.scrollToTopPlans()

            },
            deep: true
        },

        FilterTermsAreLoaded(newValue){
            if(newValue == true){                
                this.loadPlansFromFiltersTerm()
                setTimeout(() => {
                    this.loadRange()
                }, 0.2 * 1000);
            }
        },

        CaasifyUserInfo(){
            let time = this.CaasifyUserInfo.balance_alarm
            if(time != null && time < 72){
                this.showBalanceAlertModal()
            }
        },
        
        CaasifyResellerUserInfo(){
            let time = this.CaasifyResellerUserInfo.balance_alarm
            if(time != null && time < 72){
                this.showBalanceAlertModal()
            }
        },

        showAlertModal(newValue) {
            if (newValue == true) {
                $('#alertModal').modal('show');
            } else {
                $('#alertModal').modal('hide');
            }

            setTimeout(() => {
                this.showAlertModal = false
            }, 4000);
        },

        thisOrder() {
            this.findValidControllers();
        },

        fileName(newFielName) {
            if (newFielName != null) {
                if (newFielName == "reseller.php") {

                    setTimeout(() => {
                        this.LoadCaasifyResellerUser();
                        this.LoadWhmcsCurrencies();
                        setTimeout(() => {
                            this.LoadGetUserToken();
                            setTimeout(() => {
                                this.LoadWhmcsUser();
                                setTimeout(() => {
                                    this.loadPollingResellerUserPage();
                                }, 0.5 * 1000);
                            }, 0.5 * 1000);
                        }, 0.5 * 1000);
                    }, 0.5 * 1000);

                } else if (newFielName == "index.php") {
                    
                    setTimeout(() => {
                        this.LoadCaasifyUser();
                        this.LoadCaasifyResellerUser();
                        setTimeout(() => {
                            this.LoadUserOrders();
                            setTimeout(() => {
                                this.LoadWhmcsUser();
                                setTimeout(() => {
                                    this.LoadWhmcsCurrencies();
                                    setTimeout(() => {
                                        this.loadPollingIndex();
                                    }, 0.5 * 1000);
                                }, 0.5 * 1000);
                            }, 0.5 * 1000);
                        }, 0.5 * 1000);
                    }, 0.5 * 1000);

                } else if (newFielName == "create.php") {

                    setTimeout(() => {
                        this.loadFilterTerms();
                        setTimeout(() => {
                            this.LoadCaasifyUser();
                            setTimeout(() => {
                                this.LoadWhmcsUser();
                                setTimeout(() => {
                                    this.LoadWhmcsCurrencies();
                                    setTimeout(() => {
                                        this.CreateRandomHostName();
                                        this.loadPollingCreate();
                                    }, 0.5 * 1000);
                                }, 0.5 * 1000);
                            }, 0.5 * 1000);
                        }, 0.5 * 1000);
                    }, 0.5 * 1000);
                    
                } else if (newFielName == "view.php") {

                    this.orderId();
                    setTimeout(() => {
                        this.LoadTheOrder();
                        setTimeout(() => {
                            this.LoadCaasifyUser();
                            setTimeout(() => {
                                this.LoadWhmcsUser();
                                setTimeout(() => {
                                    this.LoadWhmcsCurrencies();
                                    setTimeout(() => {
                                        this.LoadOrderViews();
                                        setTimeout(() => {
                                            this.LoadActionsHistory();
                                            setTimeout(() => {
                                                this.LoadOrderTraffics();
                                                setTimeout(() => {
                                                    this.loadPollingViewMachine();
                                                }, 2 * 1000);
                                            }, 0.5 * 1000);
                                        }, 0.5 * 1000);
                                    }, 2 * 1000);
                                }, 0.5 * 1000);
                            }, 0.5 * 1000);
                        }, 0.5 * 1000);
                    }, 0.5 * 1000);
                    
                } else if (newFielName == "finance.php") {
                    this.LoadExpenseDates()
                    this.LoadCaasifyUser();
                    setTimeout(() => {
                        this.LoadWhmcsUser();
                        setTimeout(() => {
                            this.LoadWhmcsCurrencies();
                            setTimeout(() => {
                                // this.loadPollingFinance();
                            }, 0.5 * 1000);
                        }, 0.5 * 1000);
                    }, 0.5 * 1000);
   
                }
            }
        },

        CaasifyConfigs(NewCaasifyConfigs) {
            this.config.MinimumCharge = parseFloat(NewCaasifyConfigs.MinimumCharge)
            this.config.MaximumCharge = parseFloat(NewCaasifyConfigs.MaximumCharge)
            this.config.MinBalanceAllowToCreate = parseFloat(NewCaasifyConfigs.MinBalanceAllowToCreate)
            this.config.MonthlyCostDecimal = parseFloat(NewCaasifyConfigs.MonthlyCostDecimal)
            this.config.HourlyCostDecimal = parseFloat(NewCaasifyConfigs.HourlyCostDecimal)
            this.config.BalanceDecimal = parseFloat(NewCaasifyConfigs.BalanceDecimal)
            this.config.DemoMode = NewCaasifyConfigs.DemoMode
            this.config.Commission = parseFloat(atob(NewCaasifyConfigs.Commission)) 
            this.config.MyCaasifyStatus = parseFloat(NewCaasifyConfigs.MyCaasifyStatus)
        },

        orderID(neworderID) {
            setTimeout(() => {
                this.LoadRequestNewView();
            }, 15 * 1000);
        },

        systemUrl(newsystemUrl) {
            if (newsystemUrl != '') {
                this.loadUrl();
            }
        },

        SelectedRegion() {
            this.loadPlans()
        },

        SelectedExpenseDate() {
            this.loadExpenses()
        },
    },

    updated() {
        // Re-initialize tooltips when the DOM is updated
        this.initializeTooltips();
    },

    mounted() {
        const interval = setInterval(() => {
            if (this.increasing) {
                this.opacity += 0.05;
                if (this.opacity >= 1) {
                    this.opacity = 1; // Cap at 1
                    this.increasing = false; // Switch to decreasing
                }
            } else {
                this.opacity -= 0.05;
                if (this.opacity <= 0.1) {
                    this.opacity = 0.1; // Cap at 0.1
                    this.increasing = true; // Switch to increasing
                }
            }
        }, 30); // 0.2 seconds (200ms) per interval
        
        // this.mountToolTips();
        this.scrollToTop();
        this.fetchModuleConfig();
        this.readLanguageFirstTime();
        this.mountToolTips();

        this.selectCategory(this.parentCategories[0])
    },

    computed: {

        AllPlansSorted(){
            let plans = false
            if(this.plansAreLoaded && !this.recomPlansAreLoaded){
                if(this.plans.length != 0){
                    plans = this.plans
                }
            } else if(this.plansAreLoaded && this.recomPlansAreLoaded){
                if(this.plans.length != 0){
                    if(this.recomPlans.length != 0){
                        plans = this.plans.concat(this.recomPlans)
                    } else {
                        plans = this.plans
                    }
                } 
            }

            let thereIsAtLeastOneOrdinaryPlan = false
            if(plans.length > 0){
                plans.forEach(plan => {
                    if(plan.capacity == null){
                        thereIsAtLeastOneOrdinaryPlan = true
                    }
                    if(plan.capacity != null){
                        if(plan.capacity.available == true){
                            thereIsAtLeastOneOrdinaryPlan = true
                        }
                    } 
                });
            }
            
            if(thereIsAtLeastOneOrdinaryPlan){
                if(plans.length > 1){
                    plans = plans.slice().sort((a, b) => a.price - b.price);
                }
            } else {
                this.noPlanToShow = true
                plans = this.favoritPlans
            } 

            let thereIsAtLeastOne = false
            plans.forEach(plan => {
                if(plan.capacity == null){
                    thereIsAtLeastOne = true
                }
                if(plan.capacity != null){
                    if(plan.capacity.available == true){
                        thereIsAtLeastOne = true
                    }
                }
            });

            
            if(thereIsAtLeastOne == true && plans.length > 0){
                return plans
            } else {
                return false
            }
        },

        ConsoleParams(){
            if(this.latestConsoleRequestId != null){
                let references = null;
                for (let index in this.ActionHistory) {                    
                    if (this.ActionHistory[index].id == this.latestConsoleRequestId){
                        references = this.ActionHistory[index].references;
                    }
                }

                let ConsoleParams = {};

                if(references != ''){
                    for(let key in references){
                        ConsoleParams [references[key]?.reference?.type] = references[key]?.value 
                        this.endLoadHistoryForConsole = true
                        this.ConsoleTimer = 60
                        this.CountDownConsoleTimer()
                        this.WaitForConsoleRoute = false
                    }
                }

                return ConsoleParams
            }
            return null
        },

        ConsoleLinkIsValid(){
            if(this.ConsoleTimer != null && this.ConsoleTimer > 0){
                return true
            } else {
                return false
            }
        },

        thisProductHasConsole(){
            if(this.thisOrder){
                let buttons = this.thisOrder?.records[this.thisOrder.records.length - 1]?.product?.groups[1]?.buttons
                let button = null;
                for (let key in buttons) {
                    if (buttons.hasOwnProperty(key)) {
                        button = buttons[key];
                        if(button.type.toLowerCase() == 'console'){
                            return true;
                        }
                    }
                }
                console.error('Order has no Console')
                return false
            }
            return null;
        },
        
        sortedFiltersTerm() {
            const priorityItems = ['CPU', 'Disk', 'Ram', 'Traffic'];
        
            return this.FilterTerms.slice().sort((a, b) => {
                // Check if both items are in the priority list
                const indexA = priorityItems.indexOf(a.name);
                const indexB = priorityItems.indexOf(b.name);
        
                // If both are in the priority list, sort by their position in priorityItems
                if (indexA !== -1 && indexB !== -1) {
                    return indexA - indexB;
                }
        
                // If one is in the priority list, it comes first
                if (indexA !== -1) return -1;
                if (indexB !== -1) return 1;
        
                // If neither is in the priority list, sort alphabetically
                return a.name.localeCompare(b.name);
            });
        },
        

        CommissionIsValid() {
            if (this.configIsLoaded == false) {
                return true
            }

            if (this.config != null) {
                if (this.config?.Commission != null) {
                    if (typeof this.config.Commission == 'number' && isFinite(this.config.Commission)) {
                        return true
                    }
                }
            }
            return false
        },

        userCurrencySymbolFromWhmcs() {
            if (this.WhmcsCurrencies != null && this.userCurrencyIdFromWhmcs != null) {
                let CurrencyArr = this.WhmcsCurrencies.currency
                let id = this.userCurrencyIdFromWhmcs
                let UserCurrency = null

                CurrencyArr.forEach((item) => {
                    if (item.id == id) {
                        UserCurrency = item.suffix;
                    }
                });

                if (UserCurrency) {
                    return UserCurrency
                } else {
                    return null
                }
            } else {
                return null
            }
        },

        balance() {
            if (this.user.balance) {
                return this.user.balance
            } else {
                return null
            }
        },

        activeorders() {
            let listOforders = []
            if (this.isNotEmpty(this.UserOrders)) {

                listOforders = _.filter(this.UserOrders, order => this.isActive(order.status))

            }
            return listOforders
        },

        chargeAmountInCaasifyCurrency() {
            if (this.chargeAmountinWhmcs != null && this.CurrenciesRatioWhmcsToCloud != null) {
                let value = this.convertFromWhmcsToCloud(this.chargeAmountinWhmcs)
                return value
            } else {
                return null
            }
        },

        UserCreditInCaasifyCurrency() {
            if (this.userCreditinWhmcs != null && this.CurrenciesRatioWhmcsToCloud != null) {
                let value = this.convertFromWhmcsToCloud(this.userCreditinWhmcs)
                return value
            } else {
                return null
            }
        },

        NewChargingValidity() {
            let chargeAmount = this.chargeAmountInCaasifyCurrency;
            let minimum = this.config.MinimumCharge;
            let maximum = this.config.MaximumCharge;

            if (chargeAmount == null) {
                return null
            } else {
                if (chargeAmount < minimum) {
                    return "noenoughchargeamount"
                } else if (!this.isIntOrFloat(chargeAmount)) {
                    return "notinteger"
                } else if (chargeAmount > maximum) {
                    return "MoreThanMax"
                } else {
                    return "fine"
                }
            }
            return null
        },
        
        chargingValidity() {
            if (this.CurrenciesRatioWhmcsToCloud != null) {
                let usercredit = this.UserCreditInCaasifyCurrency;
                let chargeAmount = this.chargeAmountInCaasifyCurrency;
                let minimum = this.config.MinimumCharge;
                let maximum = this.config.MaximumCharge;

                if (usercredit == null || chargeAmount == null) {
                    return null
                } else {
                    if (usercredit == 0) {
                        return "nocredit"
                    } else if (usercredit < minimum) {
                        return "noenoughcredit"
                    } else if (chargeAmount < minimum) {
                        return "noenoughchargeamount"
                    } else if (!this.isIntOrFloat(chargeAmount)) {
                        return "notinteger"
                    } else if (chargeAmount > maximum) {
                        return "MoreThanMax"
                    } else if (chargeAmount > usercredit) {
                        return "overcredit"
                    } else {
                        return "fine"
                    }
                }
            } else {
                return null
            }
        },

        chargeAmountAdminInputisvalide() {
            let value = this.chargeAmountAdminInput;
            if (value != null && this.isIntOrFloat(value)) {
                return true
            } else {
                return false
            }
        },

        CurrenciesRatioCloudToWhmcs() {
            if (this.userCurrencyIdFromWhmcs != null && this.CaasifyDefaultCurrencyID != null) {
                let userCurrencyId = this.userCurrencyIdFromWhmcs;
                let CaasifyCurrencyID = this.CaasifyDefaultCurrencyID;

                if (userCurrencyId == CaasifyCurrencyID) {
                    return 1
                } else {
                    let userCurrencyRatio = this.findRationFromId(userCurrencyId)
                    let CaasifyCurrencyRatio = this.findRationFromId(CaasifyCurrencyID)

                    if (userCurrencyRatio != null && CaasifyCurrencyRatio != null) {
                        return userCurrencyRatio / CaasifyCurrencyRatio;
                    } else {
                        return null
                    }
                }
            } else {
                return null
            }
        },

        CurrenciesRatioWhmcsToCloud() {
            if (this.CurrenciesRatioCloudToWhmcs != null) {
                return 1 / this.CurrenciesRatioCloudToWhmcs
            } else {
                return null
            }
        },

        CaasifyDefaultCurrencySymbol() {
            if (this.CaasifyConfigs?.CaasifyCurrency != null) {
                return this.CaasifyConfigs.CaasifyCurrency
            } else {
                return null
            }
        },

        CaasifyDefaultCurrencyID() {
            let CaasifyDefaultCurrencyID = null
            if (this.WhmcsCurrencies != null && this.CaasifyConfigs != null) {
                let CaasifyCurrency = this.CaasifyConfigs?.CaasifyCurrency;
                let WhmcsCurrencies = this.WhmcsCurrencies;

                if (CaasifyCurrency != null && WhmcsCurrencies.currency != null) {
                    WhmcsCurrencies?.currency.forEach((item, index) => {
                        if (item.code == CaasifyCurrency) {
                            CaasifyDefaultCurrencyID = item.id
                        }
                    })
                } else {
                    console.error('finfing caasify currency ID failed');
                }
            }
            return CaasifyDefaultCurrencyID
        },

        TotalMachinePrice() {
            let TotalMachinePrice = null
            let decimal = this.config.MonthlyCostDecimal

            if (this.SelectedPlan?.price != null && this.SumConfigPrice() != null) {
                let planPrice = this.SelectedPlan.price
                let ConfigPrice = this.SumConfigPrice()

                let planPriceFloat = parseFloat(planPrice);
                let ConfigPriceFloat = parseFloat(ConfigPrice);

                if (!isNaN(planPriceFloat) && !isNaN(ConfigPriceFloat)) {
                    TotalMachinePrice = planPriceFloat + ConfigPriceFloat;
                    return TotalMachinePrice
                }
            }
            return NaN
        },

        // Mycaasify
        ResellerUserBalance() {
            if (this.CaasifyResellerUserInfo?.balance != null && this.CaasifyResellerUserInfo?.debt != null) {
                let ResellerUserBalance = Number(this.CaasifyResellerUserInfo?.balance - this.CaasifyResellerUserInfo?.debt ).toFixed(2)
                if (ResellerUserBalance) {
                    return ResellerUserBalance
                }
            } else {
                return null
            }
        },


        ResellerUserCredit() {
            if (this.WhmcsUserInfo?.credit) {
                let ResellerUserCredit = Number(this.WhmcsUserInfo?.credit).toFixed(2)
                if (ResellerUserCredit) {
                    return ResellerUserCredit
                }
            } else {
                return null
            }
        },

        ResellerChargingValidity() {
            if (this.ResellerUserCredit != null) {
                let usercredit = parseFloat(this.ResellerUserCredit);
                let chargeAmount = parseFloat(this.ResellerChargeAmount);
                let minimum = parseFloat(this.config.MinimumCharge);
                let maximum = parseFloat(this.config.MaximumCharge);

                if (usercredit == null || chargeAmount == null) {
                    return null
                } else {
                    if (usercredit == 0) {
                        return "nocredit"
                    } else if (usercredit < minimum) {
                        return "noenoughcredit"
                    } else if (chargeAmount < minimum) {
                        return "noenoughchargeamount"
                    } else if (!this.isIntOrFloat(chargeAmount)) {
                        return "notinteger"
                    } else if (chargeAmount > maximum) {
                        return "MoreThanMax"
                    } else if (chargeAmount > usercredit) {
                        return "overcredit"
                    } else {
                        return "fine"
                    }
                }
            }

            return null
        },

    },

    methods: {

        initializeTooltips() {
            // Select all tooltip elements and initialize them
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach((tooltipTriggerEl) => {
              new bootstrap.Tooltip(tooltipTriggerEl);
            });
        },

        CountDownConsoleTimer() {
            const intervalId = setInterval(() => {
                if (this.ConsoleTimer > 0) {
                    this.ConsoleTimer -= 1;
                } else {
                    this.ConsoleTimer = null
                    clearInterval(intervalId);
                }
            }, 1000);
        },
        
        showTrafficPriceInWhmcsUint(price) {
            if (isNaN(price) || price == null) {
                console.error('Price in showTrafficPriceInWhmcsUint is null')
                return NaN
            }

            let FloatPrice = parseFloat(price);
            if (isNaN(FloatPrice) || FloatPrice == null) {
                console.error('FloatPrice in showTrafficPriceInWhmcsUint is not Float')
                return NaN
            }

            let PriceWithCommission = this.addCommision(FloatPrice)
            if (isNaN(PriceWithCommission) || PriceWithCommission == null) {
                console.error('PriceWithCommission is null in showTrafficPriceInWhmcsUint')
                return NaN
            }

            let PriceInWhCurrency = this.ConvertFromCaasifyToWhmcs(PriceWithCommission)
            if (isNaN(PriceInWhCurrency)) {
                console.error('PriceInWhCurrency is null in showTrafficPriceInWhmcsUint')
                return NaN
            }

            let FormattedPrice = this.formatCostMonthly(PriceInWhCurrency)

            if (isNaN(FormattedPrice) || FormattedPrice == null) {
                console.error('FormattedPrice is null in showTrafficPriceInWhmcsUint')
                return NaN
            }

            if(FormattedPrice < 1){
                return (Math.floor(FormattedPrice * 10000) / 10000).toFixed(4);
            } else {
                return FormattedPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

        },

        showBalanceAlertModal() {
            $('#BalanceAlertModal').modal('show');
        },

        changeVisibility() {
            this.showToken = !this.showToken
        },

        copyUserToken(text) {
            this.BtnCopyTokenPushed = true
            if (text) {
                text = this.usertoken;
            }
            navigator.clipboard.writeText(text).then(function () {
            }).catch(function (error) {
                console.error('copyUserToken failed');
            });

            setTimeout(() => {
                this.BtnCopyTokenPushed = false
            }, 1000);
        },

        loadPollingResellerUserPage() {
            setInterval(this.LoadWhmcsUser, 20 * 1000)
            setInterval(this.LoadCaasifyUser, 20 * 1000)
            setInterval(this.LoadGetUserToken, 20 * 1000)
        },

        async LoadGetUserToken() {
            const params = { WhUserId: this.WhUserId };

            RequestLink = this.CreateRequestLink(action = 'CaasifyGetUsertoken');
            let response = await axios.post(RequestLink, params);

            if (response?.data == 'null') {
                console.error('GetUserToken Is Null');
                return null;
            }

            if (response?.data?.data) {
                this.usertoken = response.data.data
            } else if (response?.data?.message) {
                console.error('GetUserToken: ' + response.data.message);
            }
        },

        async LoadCaasifyResellerUser() {
            RequestLink = this.CreateRequestLink(action = 'CaasifyResellerUserInfo');
            let response = await axios.get(RequestLink);

            if (response?.data == null) {
                console.error('Caasify Reseller User Is Null');
            }

            if (response?.data?.data) {
                this.CaasifyResellerUserIsLoaded = true
                this.CaasifyResellerUserInfo = response.data.data

                this.user = response?.data.data
                this.ConstUserId = Object.freeze({ value: response?.data?.data.id });
            } else if (response?.data?.message) {
                this.CaasifyResellerUserIsLoaded = true
                // console.error('CaasifyResellerUserInfo: ' + response.data.message);
            }
        },

        async StartTransferResellerUser() {
            this.ConstResellerChargeAmount = Object.freeze({ value: this.ResellerChargeAmount });
            let ChargeAmount = this.ConstResellerChargeAmount.value
            let chargingValidity = this.ResellerChargingValidity;
            this.theChargingSteps = 1;
            this.theStepStatus = 11;

            const params = { chargeamount: ChargeAmount };

            if (chargingValidity == 'fine') {
                RequestLink = this.CreateRequestLink(action = 'CreateUnpaidInvoice');
                let response = await axios.post(RequestLink, params);
                if (response?.data.result == 'success') {
                    this.invoice = response?.data;
                    this.ConstantInvoiceId = Object.freeze({ value: response?.data.invoiceid });
                    setTimeout(() => {
                        this.theStepStatus = 12;
                        this.ResellerChargeCaasify();
                    }, 0.1 * 1000);
                } else {
                    this.GlobalError = 1
                    setTimeout(() => {
                        this.theStepStatus = 13;
                        this.TransactionError = 'error 1',
                            setTimeout(() => {
                                this.FailWindow();
                            }, 1000);
                    }, 1000);
                }
            } else {
                return null
            }
        },

        async ResellerChargeCaasify() {
            const id = this.ConstUserId.value;
            let ChargeAmount = this.ConstResellerChargeAmount.value
            const invoiceid = this.ConstantInvoiceId.value

            this.theChargingSteps = 2;
            this.theStepStatus = 21;

            const params = {
                chargeamount: ChargeAmount,
                id: id,
                invoiceid: invoiceid,
            };

            if (id > 0) {
                RequestLink = this.CreateRequestLink(action = 'resellerChargeCaasify');
                let response = await axios.post(RequestLink, params);
                if (response?.data.data) {
                    setTimeout(() => {
                        this.theStepStatus = 22;
                        this.ResellerApplyTheCredit();
                    }, 0.1 * 1000);
                } else {

                    if (response?.data?.message) {
                        this.ChargeMSG = response?.data?.message
                    }

                    this.GlobalError = 2
                    this.markCancelInvoice()
                    setTimeout(() => {
                        this.theStepStatus = 23;
                        this.TransactionError = 'error 2',
                            setTimeout(() => {
                                this.FailWindow();
                            }, 1000);
                    }, 1000);
                }
            } else {
                return null
            }
        },

        async ResellerApplyTheCredit() {
            const invoiceid = this.ConstantInvoiceId.value;
            let ChargeAmount = this.ConstResellerChargeAmount.value

            this.theChargingSteps = 3;
            this.theStepStatus = 31;

            const params = { invoiceid: invoiceid, chargeamount: ChargeAmount };

            if (invoiceid > 0) {
                RequestLink = this.CreateRequestLink(action = 'applyTheCredit');
                let response = await axios.post(RequestLink, params);

                if (response?.data.result == 'success') {
                    setTimeout(() => {
                        this.theStepStatus = 32;
                        setTimeout(() => {
                            this.SuccessWindow();
                        }, 1000);
                    }, 1000);
                } else {
                    this.GlobalError = 3
                    setTimeout(() => {
                        this.theStepStatus = 33;
                        this.TransactionError = 'error 3',
                            setTimeout(() => {
                                this.FailWindow();
                            }, 1000);
                    }, 1000);
                }
            } else {
                return null
            }
        },

        async ResellerMarkCancelInvoice() {
            const invoiceid = this.ConstantInvoiceId.value;
            const params = { invoiceid: invoiceid };
            RequestLink = this.CreateRequestLink(action = 'markCancelInvoice');
            let response = await axios.post(RequestLink, params);
            if (response?.data.result == 'success') {
                console.error('Invoice is marked cancelled successfully');
            } else {
                console.error('can not able to clear invoice');
            }
        },

        // Other
        addCommision(value) {
            if (this.config.Commission !== null && this.config.Commission !== undefined) {
                let Commission = parseFloat(this.config.Commission);
                if (!isNaN(Commission)) {
                    return ((100 + Commission) / 100) * value;
                } else {
                    console.error('Commission is not a valid number');
                    return NaN
                }
            } else {
                console.error('Commission is null or undefined');
                return null
            }
        },

        RunDemoModal() {
            $('#DemotModalCreateSuccess').modal('show');
            $('#createModal').modal('hide');
        },

        CheckData() {

            if (this.WhmcsUserIsNull == true) {
                this.LoadWhmcsUser();
            }


            if (this.CaasifyUserIsNull == true) {
                this.LoadCaasifyUser();
            }

            if (this.WhmcsCurrencies == null) {
                this.LoadWhmcsCurrencies();
            }
        },

        CheckDataCenterLoaded() {
            if (this.DataCenterIsNull == true) {
                this.loadDataCenters();
            }
        },

        loadUrl() {
            let url = window.location.href;
            let pathname = new URL(url).pathname;
            var parts = pathname.split('/');
            var filename = parts[parts.length - 1];
            this.fileName = filename;
        },

        fetchModuleConfig() {
            this.configIsLoaded = false
            fetch('configApi.php')  // Use a relative path to reference the PHP file
                .then(response => response.json())
                .then(data => {
                    this.configIsLoaded = true
                    this.CaasifyConfigs = data.configs;
                    if (this.CaasifyConfigs['errorMessage'] == null) {
                        this.systemUrl = data.configs.systemUrl;
                        if (this.systemUrl.endsWith('/')) {
                            this.systemUrl = this.systemUrl.slice(0, -1);
                        }
 
                        this.BackendUrl = data.configs.BackendUrl;
                        if (this.systemUrl == '') {
                            console.error('systemUrl is empty');
                        }
                    } else {
                        console.error('Error Config: ' + this.CaasifyConfigs['errorMessage']);
                    }
                })
                .catch(error => {
                    this.configIsLoaded = true
                    console.error('Error fetching root directory address:');
                });
        },

        readLanguageFirstTime() {
            this.PanelLanguage = this.getCookieValue('temlangcookie');
        },

        changeLanguage() {
            let newLang = this.PanelLanguage;
            document.cookie = `temlangcookie=${newLang}; expires=${new Date(Date.now() + 365 * 86400000).toUTCString()}; path=/`;
            window.location.reload();
        },

        getCookieValue(cookieName) {
            const name = cookieName + "=";
            const decodedCookie = decodeURIComponent(document.cookie);
            const cookieArray = decodedCookie.split(';');

            for (let i = 0; i < cookieArray.length; i++) {
                let cookie = cookieArray[i];
                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1);
                }
                if (cookie.indexOf(name) === 0) {
                    return cookie.substring(name.length, cookie.length);
                }
            }
            return null; // Return an empty string if the cookie is not found
        },

        lang(name) {
            let output = name
            _.forEach(words, function (first, second) {
                if (second.toLowerCase() == name.toLowerCase()) {
                    output = first
                }
            })
            return output
        },

        CreateRequestLink(action) {
            let systemUrl = this.systemUrl;
            let RequestLink = systemUrl + '/index.php?m=caasify&action=' + action;
            return RequestLink;
        },

        async LoadUserOrders() {
            let RequestLink = this.CreateRequestLink(action = 'UserOrders');
            let response = await axios.get(RequestLink);

            if (response?.data) {
                this.OrdersLoaded = true;
            }

            if (response?.data?.data) {
                this.UserOrders = response?.data?.data;
            } else if (response?.data?.message) {
                console.error(response?.data?.message);
            } else {
                console.error('LoadUserOrders: Unknown');
            }
        },

        async LoadCaasifyUser() {
            RequestLink = this.CreateRequestLink(action = 'CaasifyUserInfo');
            let response = await axios.get(RequestLink);

            if (response?.data == null) {
                console.error('Caasify User Is Null');
                this.CaasifyUserIsNull = true
            } else {
                this.CaasifyUserIsNull = false
            }

            if (response?.data?.data) {
                this.CaasifyUserInfo = response.data.data

                this.user = response?.data.data
                this.ConstUserId = Object.freeze({ value: response?.data?.data.id });
            } else if (response?.data?.message) {
                // console.error('CaasifyUserInfo: ' + response.data.message);
            }
        },

        async LoadWhmcsUser() {
            RequestLink = this.CreateRequestLink(action = 'WhmcsUserInfo'); 
            let response = await axios.get(RequestLink);

            if (response?.data == null) {
                console.error('WHMCS User Is Null');
                this.WhmcsUserIsNull = true
            } else {
                this.WhmcsUserIsNull = false
            }

            if (response?.data) {
                this.WhmcsUserInfo = response.data

                this.userCreditinWhmcs = response?.data.credit;
                this.userCurrencyIdFromWhmcs = response?.data.userCurrencyId;
            } else {
                console.error('WhmcsUserInfo: ' + 'no response');
            }
        },

        async LoadWhmcsCurrencies() {
            RequestLink = this.CreateRequestLink(action = 'WhmcsCurrencies');
            let response = await axios.get(RequestLink);
            if (response?.data) {
                this.WhmcsCurrencies = response.data.currencies
            } else {
                console.error('WhmcsCurrencies: ' + 'no response');
            }
        },

        scrollToTop() {
            const topElement = document.getElementById('top');
            if (topElement) {
                topElement.scrollIntoView({ behavior: 'smooth' });
            }
        },

        scrollToRegions() {
            const Element = document.getElementById('RegionsPoint');
            if (Element) {
                Element.scrollIntoView({ behavior: 'smooth' });
            }
        },

        scrollToPlans() {
            const Element = document.getElementById('plansPoint');
            if (Element) {
                Element.scrollIntoView({ behavior: 'smooth' });
            }
        },
        
        scrollToTopPlans() {
            const Element = document.getElementById('topSelect');
            if (Element) {
                Element.scrollIntoView({ behavior: 'smooth' });
            }
        },

        scrollToConfig() {
            const Element = document.getElementById('configsPoint');
            if (Element) {
                Element.scrollIntoView({ behavior: 'smooth' });
            }
        },

        isIntOrFloat(value) {
            if (typeof value === 'number' && !Number.isNaN(value)) {
                return true
            } else {
                return false
            }
        },

        convertFromWhmcsToCloud(value) {
            if (this.CurrenciesRatioWhmcsToCloud) {
                let ratio = this.CurrenciesRatioWhmcsToCloud
                return value * ratio
            } else {
                return null
            }
        },

        ConvertFromCaasifyToWhmcs(value) {
            if (this.CurrenciesRatioCloudToWhmcs) {
                let ratio = this.CurrenciesRatioCloudToWhmcs
                return value * ratio
            } else {
                return null
            }
        },

        formatNumbers(number, decimal = 2) {
            number = parseFloat(number);
            return Number(number).toFixed(decimal);
        },

        showBalanceWhmcsUnit(value) {
            decimal = this.config.BalanceDecimal
            return Number(value).toFixed(decimal)
        },

        showBalanceCloudUnit(value) {
            decimal = this.config.BalanceDecimal
            return Number(value).toFixed(2)
        },

        showChargeAmountWhmcsUnit(value) {
            decimal = this.config.BalanceDecimal
            return Number(value).toFixed(decimal)
        },

        showChargeAmountCloudUnit(value) {
            decimal = this.config.BalanceDecimal
            return Number(value).toFixed(2)
        },

        showCreditWhmcsUnit(value) {
            decimal = this.config.BalanceDecimal
            let credit =  Number(value).toFixed(decimal)
            return credit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        showCreditCloudUnit(value) {
            decimal = this.config.BalanceDecimal
            return Number(value).toFixed(2)
        },

        showRatio(value) {
            decimal = 2
            return this.formatNumbers(value, decimal)
        },

        showMinimumeWhmcsUnit(value) {
            decimal = this.config.BalanceDecimal
            let min =  Number(value).toFixed(decimal)
            return min.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        },

        showMinimumeCloudUnit(value) {
            decimal = this.config.BalanceDecimal
            return this.formatNumbers(value, 2)
        },

        findRationFromId(id) {
            if (this.WhmcsCurrencies != null) {
                let CurrencyArr = this.WhmcsCurrencies.currency

                let rate = null
                CurrencyArr.forEach((item) => {
                    if (item.id == id) {
                        rate = item.rate;
                    }
                });
                // console.error(rate);

                if (rate) {
                    return rate
                } else {
                    return null
                }
            } else {
                return null
            }
        },

        SuccessWindow() {
            const successModal = document.getElementById('successModal');
            const chargeModal = document.getElementById('chargeModal');

            $("#chargeModal").modal('hide');
            $("#successModal").modal('show');
        },

        FailWindow() {
            const failModal = document.getElementById('failModal');
            const chargeModal = document.getElementById('chargeModal');

            $("#chargeModal").modal('hide');
            $("#failModal").modal('show');
        },

        reloadpage() {
            window.location.reload()
            this.scrollToTop();
        },

        isEmpty(value) {

            if (_.isEmpty(value)) {
                return true
            } else {
                return false
            }
        },

        isNotEmpty(value) {

            if (_.isEmpty(value)) {
                return false
            } else {
                return true
            }
        },

        getProperty(data, name, empty = null) {

            let value = _.get(data, name)

            if (value) {
                return value
            } else {
                return empty
            }
        },

        isActive(status) {

            if (status == 'active') {
                return true
            } else {
                return false
            }
        },

        isPassive(status) {

            if (status == 'offline') {
                return true
            } else {
                return false
            }
        },

        open(order) {
            let base = ''
            if (this.systemUrl != null) {
                base = this.systemUrl
            }
            let address = base + '/modules/addons/caasify/views/view/view.php'
            let params = new URLSearchParams({
                'id': order.id
            }).toString()
            window.open([address, params].join('?'), "_top")
        },

        openInvoicePage() {
            let invoiceId = this.invoiceId
            let base = ''
            if (this.systemUrl != null) {
                base = this.systemUrl
            }
            if(invoiceId != null){
                let address = base + '/viewinvoice.php?id=' + invoiceId
                window.open([address], "_top")
            }
            else {
                console.error('can not find the invoice ID');
            }
        },
        
        openCreatePage() {
            let base = ''
            if (this.systemUrl != null) {
                base = this.systemUrl
            }
            let address = base + '/modules/addons/caasify/views/view/create.php'
            window.open([address], "_top")
        },
        
        openFinancePage() {
            let base = ''
            if (this.systemUrl != null) {
                base = this.systemUrl
            }
            let address = base + '/modules/addons/caasify/views/view/finance.php'
            window.open([address], "_top")
        },

        openIndexPage() {
            let base = ''
            if (this.systemUrl != null) {
                base = this.systemUrl
            }
            let address = base + '/index.php?m=caasify&action=pageIndex'
            window.open([address], "_top")
        },

        address(order) {

            let listOfReserves = []

            if (this.isNotEmpty(order)) {

                listOfReserves = _.filter(order.reserves, reserve => this.isActive(reserve.status))
            }

            let listOfIPs = []

            _.forEach(listOfReserves, function (reserve) {

                listOfIPs.push(reserve.address.address)
            })

            return listOfIPs.shift()
        },

        online(order) {

            let status = this.getProperty(order, 'powerStatus.value')

            if (this.isOnline(status)) {
                return true
            } else {
                return false
            }
        },

        offline(order) {

            let status = this.getProperty(order, 'powerStatus.value')

            if (this.isOffline(status)) {
                return true
            } else {
                return false
            }
        },

        async NewCreateUnpaidInvoice() {
            let Chargeamount = this.chargeAmountinWhmcs;
            let CaasifyUserId = this.CaasifyUserInfo?.id;
            let NewChargingValidity = this.NewChargingValidity;
            this.InvoiceCreationStatus = 'start';

            const params = { 
                Chargeamount: Chargeamount,
                CaasifyUserId: CaasifyUserId,
                Ratio: this.CurrenciesRatioWhmcsToCloud.toFixed(8)
             };

            if (NewChargingValidity == 'fine') {
                RequestLink = this.CreateRequestLink(action = 'CreateNewUnpaidInvoice');
                let response = await axios.post(RequestLink, params);
                if (response?.data.result == 'success') {
                    this.invoiceId = response?.data?.invoiceid
                    setTimeout(() => {
                        this.InvoiceCreationStatus = 'success';
                        if(this.invoiceId){
                            setTimeout(() => {
                                this.openInvoicePage()
                            }, 0.2 * 1000);
                        }
                    }, 1 * 1000);
                } else {
                    setTimeout(() => {
                        this.InvoiceCreationStatus = 'fail';
                    }, 2000);
                }
            } else {
                return null
            }
        },
        
        async ResellerNewCreateUnpaidInvoice() {
            let Chargeamount = this.chargeAmountinWhmcs;
            let SelectedGetway = this.SelectedGetway;
            let NewChargingValidity = this.NewChargingValidity;
            let CaasifyUserId = this.CaasifyResellerUserInfo?.id;
            this.InvoiceCreationStatus = 'start';

            const params = { 
                Chargeamount: Chargeamount,
                SelectedGetway: SelectedGetway,
                CaasifyUserId: CaasifyUserId,
                Ratio: this.CurrenciesRatioWhmcsToCloud.toFixed(8)
             };

            if (NewChargingValidity == 'fine') {
                RequestLink = this.CreateRequestLink(action = 'ResellerCreateNewUnpaidInvoice');
                let response = await axios.post(RequestLink, params);
                if (response?.data.result == 'success') {
                    this.invoiceId = response?.data?.invoiceid
                    setTimeout(() => {
                        this.InvoiceCreationStatus = 'success';
                        if(this.invoiceId){
                            setTimeout(() => {
                                this.openInvoicePage()
                            }, 0.2 * 1000);
                        }
                    }, 1 * 1000);
                } else {
                    setTimeout(() => {
                        this.InvoiceCreationStatus = 'fail';
                    }, 2000);
                }
            } else {
                return null
            }
        },

        async CreateUnpaidInvoice() {
            this.ConstChargeamountInWhmcs = Object.freeze({ value: this.chargeAmountinWhmcs });
            const chargeAmountinWhmcs = this.ConstChargeamountInWhmcs.value
            let chargingValidity = this.chargingValidity;
            this.theChargingSteps = 1;
            this.theStepStatus = 11;

            const params = { chargeamount: chargeAmountinWhmcs };

            if (chargingValidity == 'fine') {
                RequestLink = this.CreateRequestLink(action = 'CreateUnpaidInvoice');
                let response = await axios.post(RequestLink, params);
                if (response?.data.result == 'success') {
                    this.invoice = response?.data;
                    this.ConstantInvoiceId = Object.freeze({ value: response?.data.invoiceid });
                    setTimeout(() => {
                        this.theStepStatus = 12;
                        this.chargeCaasify();
                    }, 0.1 * 1000);
                } else {
                    this.GlobalError = 1
                    setTimeout(() => {
                        this.theStepStatus = 13;
                        this.TransactionError = 'error 1',
                            setTimeout(() => {
                                this.FailWindow();
                            }, 3000);
                    }, 3000);
                }
            } else {
                return null
            }
        },

        async chargeCaasify() {
            const id = this.ConstUserId.value;
            const chargeamountInAutovm = (this.convertFromWhmcsToCloud(this.ConstChargeamountInWhmcs.value)) / ((1 + this.config.Commission / 100));
            const invoiceid = this.ConstantInvoiceId.value

            this.theChargingSteps = 2;
            this.theStepStatus = 21;

            const params = {
                chargeamount: chargeamountInAutovm,
                id: id,
                invoiceid: invoiceid,
            };

            if (id > 0) {
                RequestLink = this.CreateRequestLink(action = 'chargeCaasify');
                let response = await axios.post(RequestLink, params);
                if (response?.data.data) {
                    setTimeout(() => {
                        this.theStepStatus = 22;
                        this.applyTheCredit();
                    }, 0.1 * 1000);
                } else {

                    if (response?.data?.message) {
                        this.ChargeMSG = response?.data?.message
                    }

                    this.GlobalError = 2
                    this.markCancelInvoice()
                    setTimeout(() => {
                        this.theStepStatus = 23;
                        this.TransactionError = 'error 2',
                            setTimeout(() => {
                                this.FailWindow();
                            }, 3000);
                    }, 3000);
                }
            } else {
                return null
            }
        },

        async markCancelInvoice() {
            const invoiceid = this.ConstantInvoiceId.value;
            const params = { invoiceid: invoiceid };
            RequestLink = this.CreateRequestLink(action = 'markCancelInvoice');
            let response = await axios.post(RequestLink, params);
            if (response?.data.result == 'success') {
                console.error('Invoice is marked cancelled successfully');
            } else {
                console.error('can not able to clear invoice');
            }
        },

        async applyTheCredit() {
            const invoiceid = this.ConstantInvoiceId.value;
            const chargeamountinWhmcs = this.ConstChargeamountInWhmcs.value

            this.theChargingSteps = 3;
            this.theStepStatus = 31;

            const params = { invoiceid: invoiceid, chargeamount: chargeamountinWhmcs };

            if (invoiceid > 0) {
                RequestLink = this.CreateRequestLink(action = 'applyTheCredit');
                let response = await axios.post(RequestLink, params);

                if (response?.data.result == 'success') {
                    setTimeout(() => {
                        this.theStepStatus = 32;
                        setTimeout(() => {
                            this.SuccessWindow();
                        }, 1000);
                    }, 1000);
                } else {
                    this.GlobalError = 3
                    setTimeout(() => {
                        this.theStepStatus = 33;
                        this.TransactionError = 'error 3',
                            setTimeout(() => {
                                this.FailWindow();
                            }, 1000);
                    }, 1000);
                }
            } else {
                return null
            }
        },

        showImage(imageAddress = null) {
            let BackendUrl = this.BackendUrl
            if (imageAddress != null && BackendUrl != null) {
                let FullImageAddress = null;
                FullImageAddress = BackendUrl + '/' + imageAddress
                return FullImageAddress
            } else {
                return null
            }
        },
        
        showLocalImage(imageAddress = null) {
            let systemUrl = this.systemUrl
            let FullImageAddress = null;
            
            if (imageAddress != null && systemUrl != null) {
                FullImageAddress = systemUrl + '/' + imageAddress
                return FullImageAddress
            } else {
                return null
            }
        },

        normallizeRangeValues(percentage, min, max, step) {
            let value = Math.ceil(percentage / 100 * (max - min) / step) * step + min
            return value.toString()
        },

        validateInput() {
            // Regular expression to allow only English letters and numbers
            const pattern = /^[A-Za-z0-9]+$/;
            if (!pattern.test(this.themachinename)) {
                this.MachineNameValidationError = true;
                if (this.themachinename.trim() !== '') {
                    this.themachinename = this.MachineNamePreviousValue;
                }
            } else {
                this.MachineNameValidationError = false;
                // Update the previous valid value
                this.MachineNamePreviousValue = this.themachinename;
            }

            if (!pattern.test(this.themachinessh)) {
                this.SshNameValidationError = true;
                if (this.themachinessh.trim() !== '') {
                    this.themachinessh = this.SshNamePreviousValue;
                }
            } else {
                this.SshNameValidationError = false;
                // Update the previous valid value
                this.SshNamePreviousValue = this.themachinessh;
            }
        },

        openConfirmDialog(action) {
            this.actionWouldBeHappened = action
            return new Promise((resolve) => this.confirmResolve = resolve)
        },

        acceptConfirmDialog() {
            this.actionWouldBeHappened = null
            this.confirmResolve(true)
        },

        closeConfirmDialog() {
            this.actionWouldBeHappened = null
            this.ChargeMSG = null
            this.CreateMSG = null

            this.confirmResolve(false)
        },

        openMessageDialog(text) {

            // Open dialog
            this.messageDialog = true

            // Content
            this.messageText = text

            // Promise
            return new Promise((resolve) => this.messageResolve = resolve)
        },

        closeMessageDialog() {

            this.messageResolve(false)

            // Close dialog
            this.messageDialog = false
        },

        showMachinePriceInWhmcsUnit(value) {
            let decimal = this.config.MonthlyCostDecimal
            return this.formatNumbers(value, decimal)
        },

        formatPrice(price, decimal = 2) {
            return Number(price).toFixed(decimal)
        },

        formatUserBalanceInEuro(UserBalnce) {
            if (isNaN(UserBalnce) || UserBalnce == null) {
                return NaN
            }

            let FloatUserBalnce = parseFloat(UserBalnce);
            if (isNaN(FloatUserBalnce) || FloatUserBalnce == null) {
                console.error('FloatUserBalnce is not Float')
                return NaN
            }

            let UserBalnceWithCommission = this.addCommision(FloatUserBalnce)
            if (isNaN(UserBalnceWithCommission) || UserBalnceWithCommission == null) {
                console.error('UserBalnceWithCommission is null')
                return NaN
            }

            let FormattedUserBalance = this.showBalanceCloudUnit(UserBalnceWithCommission)
            if (isNaN(FormattedUserBalance) || FormattedUserBalance == null) {
                console.error('FormattedUserBalance is null')
                return NaN
            }

            return FormattedUserBalance

        },
        
        formatUserBalance(UserBalnce) {
            if (isNaN(UserBalnce) || UserBalnce == null) {
                return NaN
            }

            let FloatUserBalnce = parseFloat(UserBalnce);
            if (isNaN(FloatUserBalnce) || FloatUserBalnce == null) {
                console.error('FloatUserBalnce is not Float')
                return NaN
            }

            let UserBalnceWithCommission = this.addCommision(FloatUserBalnce)
            if (isNaN(UserBalnceWithCommission) || UserBalnceWithCommission == null) {
                console.error('UserBalnceWithCommission is null')
                return NaN
            }

            let UserBalanceInWhCurrency = this.ConvertFromCaasifyToWhmcs(UserBalnceWithCommission)
            if (isNaN(UserBalanceInWhCurrency) || UserBalanceInWhCurrency == null) {
                console.error('UserBalanceInWhCurrency is null')
                return NaN
            }

            let FormattedUserBalance = this.showBalanceWhmcsUnit(UserBalanceInWhCurrency)
            if (isNaN(FormattedUserBalance) || FormattedUserBalance == null) {
                console.error('FormattedUserBalance is null')
                return NaN
            }
            
            return FormattedUserBalance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // return FormattedUserBalance

        },

        formatTotalMachinePrice(TotalMachinePrice) {
            if (isNaN(TotalMachinePrice) || TotalMachinePrice == null) {
                return NaN
            }

            let FloatTotalMachinePrice = parseFloat(TotalMachinePrice);
            if (isNaN(FloatTotalMachinePrice) || FloatTotalMachinePrice == null) {
                return NaN
            }

            let TotalMachinePriceWithCommission = this.addCommision(FloatTotalMachinePrice)
            if (isNaN(TotalMachinePriceWithCommission) || TotalMachinePriceWithCommission == null) {
                return NaN
            }

            let TotalPriceInWhCurrency = this.ConvertFromCaasifyToWhmcs(TotalMachinePriceWithCommission)
            if (isNaN(TotalPriceInWhCurrency) || TotalPriceInWhCurrency == null) {
                return NaN
            }

            let FormattedTotalPrice = this.formatCostMonthly(TotalPriceInWhCurrency)
            if (isNaN(FormattedTotalPrice) || FormattedTotalPrice == null) {
                return NaN
            }

            return FormattedTotalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // return FormattedTotalPrice

        },

        formatConfigPrice(ConfigPrice) {
            if (isNaN(ConfigPrice) || ConfigPrice == null) {
                return NaN
            }

            let FloatConfigPrice = parseFloat(ConfigPrice);
            if (isNaN(FloatConfigPrice) || FloatConfigPrice == null) {
                return NaN
            }

            let ConfigPriceWithCommission = this.addCommision(FloatConfigPrice)
            if (isNaN(ConfigPriceWithCommission) || ConfigPriceWithCommission == null) {
                return NaN
            }

            let ConfigPriceInWhCurrency = this.ConvertFromCaasifyToWhmcs(ConfigPriceWithCommission)
            if (isNaN(ConfigPriceInWhCurrency) || ConfigPriceInWhCurrency == null) {
                return NaN
            }

            let FormattedConfigePrice = this.formatCostMonthly(ConfigPriceInWhCurrency)
            if (isNaN(FormattedConfigePrice) || FormattedConfigePrice == null) {
                return NaN
            }

            return FormattedConfigePrice

        },

        formatPlanPrice(price) {
            if (isNaN(price) || price == null) {
                return NaN
            }

            let FloatPrice = parseFloat(price);
            if (isNaN(FloatPrice) || FloatPrice == null) {
                return NaN
            }

            let PriceWithCommission = this.addCommision(FloatPrice)
            if (isNaN(PriceWithCommission) || PriceWithCommission == null) {
                return NaN
            }

            let PriceInWhCurrency = this.ConvertFromCaasifyToWhmcs(PriceWithCommission)
            if (isNaN(PriceInWhCurrency)) {
                return NaN
            }

            let FormattedPrice = this.formatCostMonthly(PriceInWhCurrency)
            if (isNaN(FormattedPrice) || FormattedPrice == null) {
                return NaN
            }

            if(FormattedPrice<1){
                return (Math.floor(FormattedPrice * 10000) / 10000).toFixed(4);
            } else {
                return FormattedPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

        },

        formatCostMonthly(value) {
            let decimal = this.config.MonthlyCostDecimal
            if (value < 99999999999999 && value != null) {
                if (value > 1) {
                    return Number(value).toFixed(decimal)
                } else if (value > 0.1) {
                    return Number(value).toFixed(decimal + 1)
                } else if (value > 0.01) {
                    return Number(value).toFixed(decimal + 2)
                } else if (value > 0.001) {
                    return Number(value).toFixed(decimal + 3)
                } else if (value > 0.0001) {
                    return Number(value).toFixed(decimal + 4)
                } else if (value > 0.00001) {
                    return Number(value).toFixed(decimal + 5)
                } else if (value > 0.000001) {
                    return Number(value).toFixed(decimal + 6)
                } else {
                    return Number(value).toFixed(decimal + 10)
                }
            } else {
                return null
            }
        },

        async loadDataCenters() {
            this.DataCentersAreLoaded = false

            RequestLink = this.CreateRequestLink(action = 'CaasifyGetDataCenters');
            let response = await axios.get(RequestLink);

            if (response?.data == null) {
                console.error('DataCenters Is Null');
                this.DataCenterIsNull = true
            } else {
                this.DataCenterIsNull = false
            }

            if (response?.data?.message) {
                this.DataCentersAreLoaded = true
                this.plansAreLoaded = false
                console.error('DataCenters Error: ' + response?.data?.message);
            }
            if (response?.data?.data) {
                this.DataCentersLength = response?.data?.data.length;
                this.DataCentersAreLoaded = true
                this.plansAreLoaded = false
                this.DataCenters = response?.data?.data
            }
        },

        selectDataCenter(DataCenter) {
            this.scrollToRegions()
            if(this.SelectedDataCenter != DataCenter){    
                this.PlanConfigSelectedOptions = {}
                this.plans = [];
                this.SelectedPlan = null
                this.SelectedRegion = null
                this.PlanSections = null
                this.SelectedDataCenter = DataCenter
                this.regions = DataCenter.categories
            }
        },

        isDataCenter(DataCenter) {
            if (this.SelectedDataCenter == DataCenter) {
                return true
            } else {
                return false
            }
        },

        selectRegion(region) {
            this.scrollToPlans();

            if(this.SelectedRegion != region){                
                this.PlanConfigSelectedOptions = {}
                this.plans = [];
                this.SelectedPlan = null
                this.plansAreLoading = true
                this.plansAreLoaded = false
                this.PlanSections = null
            }

            this.SelectedRegion = region
        },

        isRegion(region) {
            if (this.SelectedRegion == region) {
                return true
            } else {
                return false
            }
        },

        selectPlan(plan) {
            this.scrollToConfig()
            this.PlanConfigSelectedOptions = {}
            this.SelectedPlan = plan
            this.PlanSections = null
            if (this.SelectedPlan != null && this.SelectedPlan?.sections) {
                this.PlanSections = this.SelectedPlan?.sections
            }
            this.initPlanConfigSelectedOptions()
        },

        isPlan(plan) {
            if (this.SelectedPlan == plan) {
                return true
            } else {
                return false
            }
        },

        thePlansTextClass(plan){
            if(plan?.detail?.vm_type.toLowerCase() == 'spot'){
                return 'text-success'
            } else {
                return 'text-primary'
            }
        },
        
        thePlansClass(plan){
            if (this.isPlan(plan)) {
                return 'bg-warning border-warning border-2 text-dark'
            } else if(this.isSuggested(plan)){
                return 'bg-primary border-primary border-2 text-dark'
            } else if(plan?.detail?.vm_type.toLowerCase() == 'spot'){
                return 'bg-success border-success'
            } else {
                return 'bg-secondary'
            }
        },
        
        thePlansStyle(plan){
            if (this.isPlan(plan)) {
                return '--bs-bg-opacity: 0.1; direction:ltr;'
            } else if(this.isSuggested(plan)){
                return '--bs-bg-opacity: 0.04; --bs-border-opacity: 0.2; direction:ltr;'
            } else if(plan?.detail?.vm_type.toLowerCase() == 'spot'){
                return '--bs-bg-opacity: 0.02; --bs-border-opacity: 0.4; direction:ltr;'
            } else {
                return '--bs-bg-opacity: 0.01;  direction:ltr;'
            }
        },

        formatDescription(description) {
            return description.replace(/\n/g, "<br />");
        },

        async loadRullesFromGit() {
            try {
                let response = await axios.get('https://raw.githubusercontent.com/autovm-modules/AutoVM-WhModules-Reseller/main/modules/addons/cloudsnp/views/autovm/includes/baselayout/rulles.php');
                this.RullesText = response.data;
            } catch (error) {
                console.error('Error fetching the file:', error);
            }
        },

        async loadPlans() {
            this.plansAreLoaded = false;
            this.plansAreLoading = true
            this.plans = [];

            if (this.SelectedRegion?.id) {
                let formData = new FormData();
                formData.append('CategoryID', this.SelectedRegion?.id);
                RequestLink = this.CreateRequestLink(action = 'CaasifyGetPlans');
                let response = await axios.post(RequestLink, formData);

                if (response?.data?.message) {
                    this.plansAreLoading = false;
                    this.plansAreLoaded = true;
                    console.error('Plans Error: ' + response?.data?.message);
                }

                if (response?.data?.data) {
                    this.plansAreLoading = false;
                    this.plansAreLoaded = true;
                    this.plans = response?.data?.data
                }
            }
        },

        async create(plan) {
            this.scrollToTop();
            let accept = await this.openConfirmDialog('create')

            if (accept) {
                if (this.config?.DemoMode != null && this.config.DemoMode.toLowerCase() == 'on') {
                    this.RunDemoModal()
                } else if (this.config?.DemoMode != null && this.config.DemoMode.toLowerCase() == 'off') {
                    this.CreateIsLoading = true;
                    let formData = new FormData();
                    formData.append('note', this.themachinename);
                    formData.append('product_id', this.SelectedPlan.id);

                    let configs = this.PlanConfigSelectedOptions;
                    for (let key in configs) {
                        if (configs[key].hasOwnProperty('value')) { // type dropdown
                            formData.append(key, configs[key].value);
                        } else if (configs[key].hasOwnProperty('options')) { // type text
                            formData.append(key, configs[key].options);
                        }
                    }

                    RequestLink = this.CreateRequestLink(action = 'CaasifyCreateOrder');
                    let response = await axios.post(RequestLink, formData);

                    if (response?.data?.data) {
                        this.userClickedCreationBtn = true
                        this.CreateIsLoading = false;
                        this.createActionSucced = true
                        this.createActionFailed = false
                        this.newMachineCreated = response?.data?.data
                        this.NewMcahineCreatedViewLink = this.systemUrl + '/modules/addons/caasify/views/view/view.php?id=' + this.newMachineCreated.id
                    } else if (response?.data?.message) {
                        this.userClickedCreationBtn = true
                        this.CreateIsLoading = false;
                        this.CreateMSG = response?.data?.message
                        this.createActionFailed = true
                        this.createActionSucced = false
                    } else {
                        this.userClickedCreationBtn = true
                        this.createActionFailed = true
                        this.CreateIsLoading = false;
                    }
                } else {
                    console.error('DemoMode is null')
                }

            }
        },

        orderId() {
            let params = new URLSearchParams(window.location.search)
            this.orderID = params.get('id')
            return params.get('id')
        },

        findValidViews() {
            this.ValidViewItems = null;
            let views = this.views;
            for (var view of views) {
                if (view?.status == "completed" && view?.items?.length > 0 && this.ValidViewItems === null) {
                    this.ValidViewItems = view.items
                    this.NewViewStatus = 'completed';
                }
            }

            if (this.ValidViewItems === null) {
                this.NoValidViewItems = true
            }
        },

        findValidControllers() {
            this.ValidControllerItems = null;
            this.NoValidControllerItems = false

            if (this.thisOrder?.records) {
                let records = this.thisOrder.records;
                for (var i = 0; i < 1; i++) {
                    let record = records[i];
                    if (this.ValidControllerItems === null) {
                        this.thisProduct = record.product
                        let groups = record.product.groups
                        for (var j = 0; j < 1; j++) {
                            let group = groups[j]
                            if (group?.buttons) {
                                if (this.ValidControllerItems === null) {
                                    this.ValidControllerItems = [];
                                }
                                this.ValidControllerItems = this.ValidControllerItems.concat(group.buttons);
                                this.ControllersAreLoading = false;
                            }
                        }
                    }
                }
            }
            if (this.ValidControllerItems == null) {
                this.NoValidControllerItems = true
            }
        },

        initPlanConfigSelectedOptions() {
            this.PlanConfigSelectedOptions = {};
            if (this.PlanSections != null && Array.isArray(this.PlanSections)) {
                for (let PlanSection of this.PlanSections) {
                    for (let field of PlanSection.fields) {
                        if (field?.type == 'dropdown') {
                            this.PlanConfigSelectedOptions[field.name] = field.options[0]
                        } else if (field?.type == 'text') {
                            this.PlanConfigSelectedOptions[field.name] = field
                        }
                    }
                }
            }
        },

        SumConfigPrice() {
            let ConfigPrice = 0
            let obj = this.PlanConfigSelectedOptions

            for (let key in obj) {
                if (obj.hasOwnProperty(key)) {
                    let price = parseFloat(obj[key]?.price);
                    if (!isNaN(price)) {
                        ConfigPrice += price;
                    }
                }
            }

            return ConfigPrice
        },

        async LoadOrderTraffics() {
            let orderID = this.orderID;
            if (orderID != null) {
                let formData = new FormData();
                formData.append('orderID', orderID);

                RequestLink = this.CreateRequestLink(action = 'CaasifyOrderTraffics');
                let response = await axios.post(RequestLink, formData);

                let inbound = 0
                let outbound = 0
                let total = 0

                if (response.data) {
                    this.trafficsIsLoaded = true
                    thisOrderTraffic = response.data
                    this.thisOrderTraffic = response.data

                    if (thisOrderTraffic?.inbound) {
                        inbound = (response.data?.inbound) / 1000 / 1000 / 1000
                        if (inbound > 1) {
                            this.TrafficInbound = Number(inbound).toFixed(2) + ' GB'
                        } else {
                            this.TrafficInbound = Number(inbound * 1000).toFixed(2) + ' MB'
                        }
                    }

                    if (thisOrderTraffic?.outbound) {
                        outbound = (response.data?.outbound) / 1000 / 1000 / 1000
                        if (outbound > 1) {
                            this.TrafficOutbound = Number(outbound).toFixed(2) + ' GB'
                        } else {
                            this.TrafficOutbound = Number(outbound * 1000).toFixed(2) + ' MB'
                        }
                    }

                    total = inbound + outbound

                    if (total == 0) {
                        this.TrafficTotal = '0 MB'
                    }
                    else if (total > 1) {
                        this.TrafficTotal = Number(total).toFixed(2) + ' GB'
                    } else {
                        this.TrafficTotal = Number(total * 1000).toFixed(2) + ' MB'
                    }


                } else if (response?.message) {
                    this.trafficsIsLoaded = true
                    console.error('Traffics: ' + response.message);
                }
            }
        },

        async LoadTheOrder() {
            let orderID = this.orderID;
            if (orderID != null) {
                let formData = new FormData();
                formData.append('orderID', orderID);

                RequestLink = this.CreateRequestLink(action = 'LoadOrder');
                let response = await axios.post(RequestLink, formData);

                if (response.data?.data != null) {
                    this.thisOrder = response.data.data
                    this.ordeIsLoaded = true

                } else if (response.data?.message) {
                    this.ordeIsLoaded = true
                    if (response?.data.message == "There is nothing.") {
                        this.userHasNoOrder = true;
                    } else {
                        console.error('UserOrders: ' + response.data.message);
                    }
                }
            }
        },

        async LoadOrderViews() {
            let orderID = this.orderID;
            if (orderID != null) {
                let formData = new FormData();
                formData.append('orderID', orderID);
                this.viewsAreLoading = true

                RequestLink = this.CreateRequestLink(action = 'CaasifyGetOrderViews');
                let response = await axios.post(RequestLink, formData);

                if (response?.data?.message) {
                    this.viewsAreLoading = false;
                    this.viewsAreLoaded = true;

                    console.error('can not find any views');
                }

                if (response?.data?.data) {
                    this.viewsAreLoading = false;
                    this.viewsAreLoaded = true;
                    // this.createCPULinearChart();
                    // this.createRAMLinearChart();
                    this.views = response?.data?.data
                    this.findValidViews()
                }
            }
        },

        async LoadRequestNewView() {
            this.NewViewStatus = null;

            let orderID = this.orderID;
            if (orderID != null) {
                let formData = new FormData();
                formData.append('orderID', orderID);

                RequestLink = this.CreateRequestLink(action = 'CaasifyRequestNewView');
                let response = await axios.post(RequestLink, formData);

                if (response?.data?.message) {
                    console.error('New View API Error: ' + response?.data?.message);
                }

                if (response?.data?.data) {
                    this.NewViewStatus = response?.data?.data?.status
                }
            }
        },

        async LoadActionsHistory() {
            let orderID = this.orderID;
            this.ActionHistoryIsLoaded = null

            if (orderID != null) {
                let formData = new FormData();
                formData.append('orderID', orderID);
                RequestLink = this.CreateRequestLink(action = 'CaasifyActionsHistory');
                let response = await axios.post(RequestLink, formData);

                if (response?.data?.message) {
                    this.ActionHistoryIsLoaded = true
                    console.error('Action History Erro: ' + response?.data?.message);
                }

                if (response?.data?.data) {
                    this.ActionHistory = response?.data?.data
                    this.ActionHistoryIsLoaded = true
                }
            }

        },

        async PushButtonController(button_id, button_name) {
            this.ActionAlertStatus = null
            this.ActionAlert = null

            let accept = await this.openConfirmDialog(button_name)
            if (accept) {
                let orderID = this.orderID;
                if (orderID != null && button_id != null) {
                    let formData = new FormData();
                    formData.append('orderID', orderID);
                    formData.append('button_id', button_id);


                    if (this.config?.DemoMode != null) {
                        if (button_name.toLowerCase() != 'delete' || this.config?.DemoMode.toLowerCase() == 'off') {
                            RequestLink = this.CreateRequestLink(action = 'CaasifyOrderDoAction');
                            let response = await axios.post(RequestLink, formData);

                            if (response?.data?.message) {
                                this.showAlertModal = true;
                                this.LoadActionsHistory()
                                this.ActionAlertStatus = 'failed'
                                this.ActionAlert = response?.data?.message
                                console.error('Action Error: ' + response?.data?.message);
                            }

                            if (response?.data?.data) {
                                this.LoadActionsHistory()
                                this.ActionAlertStatus = 'success'
                                this.ActionAlert = button_name + ' has send Successfully'
                                this.findValidViews()

                                if (button_name.toLowerCase() == 'delete') {
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 6 * 1000);
                                }
                            }

                            setTimeout(() => {
                                this.ActionAlertStatus = null
                                this.ActionAlert = null
                                this.LoadActionsHistory()
                                setTimeout(() => {
                                    if (this.ActionHistory[0].status == 'pending') {
                                        this.ActionAlertStatus = null
                                        this.ActionAlert = null
                                        this.LoadActionsHistory()
                                    }
                                }, 15 * 1000);
                            }, 15 * 1000);
                        } else {
                            console.error('DemoMode is null')
                        }
                    }
                }
            }
        },

        async PushButtonConsole() { 
            this.WaitForConsoleRoute = true
            let button_id = this.findConsoleButtonID()
            let orderID = this.orderID;
            this.latestConsoleRequestId = null
            
            if (orderID != null && button_id != null) {
                let formData = new FormData();
                formData.append('orderID', orderID);
                formData.append('button_id', button_id);


                if (this.config?.DemoMode != null) {
                    if (this.config?.DemoMode.toLowerCase() == 'off') {
                        RequestLink = this.CreateRequestLink(action = 'CaasifyOrderDoAction');
                        let response = await axios.post(RequestLink, formData);

                        if (response?.data?.message) {
                            this.WaitForConsoleRoute = false
                            $('#RequestConsoleModal').modal('hide');
                            this.showAlertModal = true;
                            this.ActionAlertStatus = 'failed'
                            this.ActionAlert = response?.data?.message
                            console.error('Console Error: ' + response?.data?.message);
                        }

                        if (response?.data?.data) {
                            this.latestConsoleRequestId = response?.data?.data?.id
                            setInterval(this.LoadActionsHistoryForConsole, 10 * 1000)
                        }
                    } else {
                        this.popupMessage = 'You can get Console inside Demo Mode';
                        this.openMessageModal('themessagemodal', this.popupMessage);
                        return false
                    }
                } else {
                    this.popupMessage = 'Mode is Unknown';
                    this.openMessageModal('themessagemodal', this.popupMessage);
                    console.error('Mode is Unknown');
                    return false
                }
            }
        },
        
        LoadActionsHistoryForConsole(){
            if(this.endLoadHistoryForConsole == false){
                if(Object.keys(this.ConsoleParams).length === 0){
                    this.LoadActionsHistory();
                }
            }
        },

        openMessageModal(ModalName, ModalMsg){
            if(ModalName != null){
                this.ModalMessage = ModalMsg
                $('#'+ModalName).modal('show');
            } else {
                console.error('No modal : ' + ModalName);
            }

            setTimeout(() => {
                $('#'+ModalName).modal('hide');
                ModalMsg = null
                this.ModalMessage = null
            }, 3000);
        },

        HandleOpenConsoleModal(){
            let button_id = null
            this.actionWouldBeHappened = 'Console'
            if(this.thisProductHasConsole == true){
                button_id = this.findConsoleButtonID()
                if(button_id == null){
                    this.popupMessage = 'Can not get Console button ID, call your admin';
                    this.openMessageModal('themessagemodal', this.popupMessage);
                    return false
                }
                $('#RequestConsoleModal').modal('show');
                return false

            } else if(this.thisProductHasConsole == false){
                this.popupMessage = 'This product has no console';
                this.openMessageModal('themessagemodal', this.popupMessage);
                return false

            } else {
                this.popupMessage = 'waittofetch';
                this.openMessageModal('themessagemodal', this.popupMessage);
                return false
            }
        },

        findConsoleButtonID(){
            if(this.thisOrder){
                let buttons = this.thisOrder?.records[this.thisOrder.records.length - 1]?.product?.groups[1]?.buttons
                if(buttons){
                    for (const key in buttons) {
                        if (buttons.hasOwnProperty(key)) {
                            if(buttons[key].type.toLowerCase() == 'console'){
                                return buttons[key].id;
                            }
                        }
                    }
                }
            }
            return null;
        },

        OpenConsoleUrl(){
            
            if(this.ConsoleParams?.address != null){
                let ConsoleParams = this.ConsoleParams
                let url = new URL(ConsoleParams.address);
                let host = url.host;
                
                let params = new URLSearchParams(url.search);
                let queryParams = {};
                let queryParamsAddress = '';
                
                for (let [key, value] of params) {
                    queryParams[key] = value;
                    queryParamsAddress += '&' + key + '=' + value
                }

                let port = '443'; 
                let password = ConsoleParams.password;

                let ConsoleUrl = this.systemUrl + "/modules/addons/caasify/views/view/includes/viewparts/noVNC/vnc_lite.html?host=" + host + '&port=' + port

                if(password != null && password != ''){
                    ConsoleUrl += '&password=' + password
                }

                if(queryParamsAddress != ''){
                    ConsoleUrl += queryParamsAddress
                }
                
                window.open(ConsoleUrl);
            } else {
                console.error('can not find console params');
                
            }

        },

        loadPollingViewMachine() {
            setInterval(this.LoadTheOrder, 30 * 1000)
            setInterval(this.LoadRequestNewView, 40 * 1000)
            setInterval(this.LoadOrderViews, 35 * 1000)
            setInterval(this.LoadActionsHistory, 50 * 1000)
            setInterval(this.LoadOrderTraffics, 50 * 1000)
            setInterval(this.CheckData, 20 * 1000)
        },

        loadPollingIndex() {
            setInterval(this.LoadUserOrders, 50 * 1000)
            setInterval(this.CheckData, 20 * 1000)
        },

        loadPollingCreate() {
            setInterval(this.CheckData, 20 * 1000)
        },

        ShowHidePassword() {
            this.PassVisible = !this.PassVisible
        },

        Is40SecondPassed(timeVariable) {
            const creationDate = new Date(timeVariable);
            const currentDate = new Date();
            const timeDifference = currentDate - creationDate;
            if (timeDifference > 40 * 1000) {
                return true
            } else {
                return false
            }
        },

        convertTime(time) {
            const formatDate = (dateString) => {
                const date = new Date(dateString);
                const months = [
                    "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                ];
                const day = date.getDate();
                const month = months[date.getMonth()];
                const hours = String(date.getHours()).padStart(2, "0");
                const minutes = String(date.getMinutes()).padStart(2, "0");

                return `${day} ${month} at ${hours}:${minutes}`;
            };

            return formatDate(time);
        },

        CreateRandomHostName() {
            const length = 7;
            const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            let result = '';
            for (let i = 0; i < length; i++) {
                result += letters.charAt(Math.floor(Math.random() * letters.length));
            }
            this.themachinename = result;
        },

        createCPULinearChart() {

            let options = this.createoption(
                chartname = ["Ram Usage"],
                data = [28, 21, 31, 89, 61, 46, 33, 18],
                colors = ['#7F56D9'],
                text = 'Ram Usage',
            )

            let element = document.querySelector('.CPULinear')
            var chart = new ApexCharts(element, options);
            chart.render();
        },

        createRAMLinearChart() {

            let options = this.createoption(
                chartname = ["CPU Usage"],
                data = [23, 22, 37, 81, 63, 41, 37, 12],
                colors = ['#2A4DD1'],
                text = 'CPU Usage',
            )



            let element = document.querySelector('.RAMLinear')
            var chart = new ApexCharts(element, options);
            chart.render();
        },

        createoption(chartname, data, colors, text) {
            let options = {
                "series": [
                    {
                        "name": chartname,
                        "data": data
                    }
                ],
                "chart": {
                    "animations": {
                        "enabled": false,
                        "easing": "swing"
                    },
                    "background": "#fff",
                    "dropShadow": {
                        "blur": 3
                    },
                    "foreColor": "#373D3F",
                    "fontFamily": "Barlow",
                    "height": 370,
                    "id": "o4Rem",
                    "toolbar": {
                        "show": false,
                        "tools": {
                            "selection": true,
                            "zoom": true,
                            "zoomin": true,
                            "zoomout": true,
                            "pan": true,
                            "reset": true
                        }
                    },
                    "fontUrl": null
                },
                "colors": colors,
                "plotOptions": {
                    "bar": {
                        "borderRadius": 10
                    },
                    "radialBar": {
                        "hollow": {
                            "background": "#fff"
                        },
                        "dataLabels": {
                            "name": {},
                            "value": {},
                            "total": {}
                        }
                    },
                    "pie": {
                        "donut": {
                            "labels": {
                                "name": {},
                                "value": {},
                                "total": {}
                            }
                        }
                    }
                },
                "dataLabels": {
                    "enabled": true,
                    "offsetY": 6,
                    "style": {
                        "fontWeight": 300
                    },
                    "background": {
                        "borderRadius": 5,
                        "borderWidth": 1
                    }
                },
                "fill": {
                    "opacity": 1
                },
                "grid": {
                    "xaxis": {
                        "lines": {
                            "show": true
                        }
                    },
                    "column": {},
                    "padding": {
                        "right": 20,
                        "bottom": 6,
                        "left": 16
                    }
                },
                "legend": {
                    "showForSingleSeries": true,
                    "position": "top",
                    "horizontalAlign": "left",
                    "fontSize": 14,
                    "offsetX": 9,
                    "offsetY": 7,
                    "markers": {
                        "width": 30,
                        "height": 16,
                        "strokeWidth": 8,
                        "radius": 13,
                        "offsetY": 3,
                    },
                    "itemMargin": {
                        "horizontal": 10
                    }
                },


                "tooltip": {},
                "xaxis": {
                    "offsetY": -2,
                    "labels": {
                        "rotate": -45,
                        "trim": true,
                        "style": {
                            "fontSize": 12,
                            "fontWeight": 300
                        }
                    },
                    "axisBorder": {
                        "show": false
                    },
                    "tickAmount": 4,
                    "title": {
                        "text": "",
                        "style": {
                            "fontSize": 12,
                            "fontWeight": 300
                        }
                    }
                },
                "yaxis": {
                    "tickAmount": 6,
                    "min": 0,
                    "labels": {
                        "style": {
                            "fontSize": 12
                        },
                        offsetX: -12,
                        offsetY: 5,
                    },
                    "title": {
                        "text": "",
                        "style": {
                            "fontSize": 12,
                            "fontWeight": 300
                        }
                    }
                }

            };
            return options
        },

        selectCategory(Category) {
            // TODO: for now
            this.SelectedCategory = this.parentCategories[0]
            // this.SelectedCategory = Category
        },

        isCategory(Category) {
            if (this.SelectedCategory == Category) {
                return true
            } else {
                return false
            }
        },

        loadPollingFinance() {
            // setInterval(this.LoadWhmcsUser, 20 * 1000)
        },

        async LoadExpenseDates() {
            this.expenseDatesMessage = null
            RequestLink = this.CreateRequestLink(action = 'CaasifyExpenseDates');
            let response = await axios.get(RequestLink);
            
            if (response.data?.data != null) {
                this.expenseDatesMessage = null
                this.expenseDatesIsLoaded = true
                this.expenseDates = response.data.data

            } else if (response.data?.message) {
                this.expenseDatesIsLoaded = true
                this.expenseDatesMessage = response?.data?.message
                console.error('Expense Dates: ' + response.data.message);
            }
        },

        async loadExpenses() {
            this.ExpensesMessage = null
            this.expenses = [];

            if (this.SelectedExpenseDate) {
                let formData = new FormData();
                formData.append('year', this.SelectedExpenseDate.year);
                formData.append('month', this.SelectedExpenseDate.month);
                RequestLink = this.CreateRequestLink(action = 'CaasifyGetExpenses');
                let response = await axios.post(RequestLink, formData);
                
                if (response?.data?.data) {
                    this.ExpensesMessage = null
                    this.expensesAreLoaded = true;
                    this.expenses = response?.data?.data
                }
                if (response?.data?.message) {
                    this.expensesAreLoaded = true;
                    this.ExpensesMessage = response?.data?.message;
                    console.error('Expenses: ' + response?.data?.message);
                }
            }
        },
        
        selectExpenseDate(expenseDate) {
            if(this.SelectedExpenseDate != expenseDate){
                this.SelectedExpenseDate = expenseDate
                this.expensesAreLoaded = false;
            }
        },

        isExpenseDate(expenseDate) {
            if (this.SelectedExpenseDate == expenseDate) {
                return true
            } else {
                return false
            }
        },

        formatExpenseAmount(ExpenseAmount) {
            
            if (isNaN(ExpenseAmount) || ExpenseAmount == null) {
                return NaN
            }

            let FloatExpenseAmount = parseFloat(ExpenseAmount);
            if (isNaN(FloatExpenseAmount) || FloatExpenseAmount == null) {
                console.error('FloatExpenseAmount is not Float')
                return NaN
            }

            let ExpenseAmountWithCommission = this.addCommision(FloatExpenseAmount)
            if (isNaN(ExpenseAmountWithCommission) || ExpenseAmountWithCommission == null) {
                console.error('ExpenseAmountWithCommission is null')
                return NaN
            }

            let ExpenseAmountInWhCurrency = this.ConvertFromCaasifyToWhmcs(ExpenseAmountWithCommission)
            if (isNaN(ExpenseAmountInWhCurrency) || ExpenseAmountInWhCurrency == null) {
                console.error('ExpenseAmountInWhCurrency is null')
                return NaN
            }

            let decimal = this.config.BalanceDecimal
            if(decimal != null && decimal == 0){
                decimal = 0
            } else if(decimal != null && decimal == 1){
                decimal = 2
            } else{
                decimal = 4
            }
            
            let FormattedExpenseAmount = Number(ExpenseAmountInWhCurrency).toFixed(decimal)

            if (isNaN(FormattedExpenseAmount) || FormattedExpenseAmount == null) {
                console.error('FormattedExpenseAmount is null')
                return NaN
            }

            return FormattedExpenseAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        },

        removeAllTooltips() {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltipEl => {
                const tooltip = bootstrap.Tooltip.getInstance(tooltipEl);
                if (tooltip) {
                    tooltip.dispose();
                }
                // Remove the _tooltipInstance property
                delete tooltipEl._tooltipInstance;
            });
        },

        mountToolTips() {
            this.removeAllTooltips();
            const intervalId = setInterval(() => {
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                tooltipTriggerList.forEach(tooltipTriggerEl => {
                    // Check if the tooltip has already been initialized
                    if (!tooltipTriggerEl._tooltipInstance) {
                        // Initialize the tooltip only if it hasn't been initialized before
                        tooltipTriggerEl._tooltipInstance = new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: 'hover focus'
                        });
                    }
                });
            }, 2 * 1000); // Run every 2 seconds
        
            // Stop the interval after 25 seconds
            setTimeout(() => {
                clearInterval(intervalId);
            }, 25 * 1000); // 25 seconds = 25,000 milliseconds
        },

        checkDataCenterCapacity(capacity, total){
            if(capacity == null || total == null){
                return true
            }
            
            if (capacity - total > 0){
                return true
            } else {
                return false
            }  
        },
        
        checkLocationCapacity(capacity, total){
            if(capacity == null || total == null){
                return true
            }
            
            if (capacity - total > 0){
                return true
            } else {
                return false
            }  
        },


        
        async loadFilterTerms() {
            this.FilterTermsAreLoaded = false

            RequestLink = this.CreateRequestLink(action = 'CaasifyGetFilterTerms');
            let response = await axios.get(RequestLink);

            if (response?.data == null) {
                console.error('FilterTerms Is Null');
                this.FilterTermsIsNull = true
            } else {
                this.FilterTermsIsNull = false
            }

            if (response?.data?.message) {
                this.FilterTermsAreLoaded = true
                this.plansAreLoaded = false
                console.error('FilterTerms Error: ' + response?.data?.message);
            }
            if (response?.data?.data) {
                this.FilterTermsLength = response?.data?.data.length;
                this.FilterTermsAreLoaded = true
                this.plansAreLoaded = false
                this.FilterTerms = response?.data?.data
            }
        },


        async loadPlansFromFiltersTerm() {
            this.plansAreLoaded = false;
            this.plansAreLoading = true
            this.plans = [];

            let response = 'no data'
            if(this.isEmpty(this.selectedTerms)){
                let formData = new FormData();
                formData.append('term[]', 291)
                RequestLink = this.CreateRequestLink(action = 'CaasifyGetPlansFromFiltersTerm');
                response = await axios.post(RequestLink, formData);
                
            } else {
                let formData = new FormData();
                for (const term in this.selectedTerms) {
                    if (this.selectedTerms.hasOwnProperty(term)) { 
                        if(Array.isArray(this.selectedTerms[term])){
                            this.selectedTerms[term].forEach(id => {
                                formData.append('term[' + term + '][' + id + ']' , id);
                            });
                        }
                    }
                }
                
                RequestLink = this.CreateRequestLink(action = 'CaasifyGetPlansFromFiltersTerm');
                response = await axios.post(RequestLink, formData);
            }

            if (response?.data?.message) {
                this.plansAreLoading = false;
                this.plansAreLoaded = true;
                console.error('Plans Error: ' + response?.data?.message);
                this.noPlanToShow = true
            }

            if (response?.data?.data) {
                this.plansAreLoading = false;
                this.plansAreLoaded = true;
                this.noPlanToShow = false
                this.plans = response?.data?.data
                if(this.isFirstRequest){
                    this.isFirstRequest = false
                    this.favoritPlans = response?.data?.data
                }
            }
        
        },

        
        async loadRecommendedPlansForContinent() {
            this.recomPlans = [];
            // check if there is country in terms to call recommends
            for (let key in this.selectedTerms) {
                if(key == 'Country'){
                    let CountryIds = this.selectedTerms['Country']
                    if (Array.isArray(CountryIds) && CountryIds?.length > 0){
                        this.noNeedToRecom = false
                        this.recomPlansAreLoaded = false;
                        this.recomPlansAreLoading = true

                        let response = 'no data'
                        if(!this.isEmpty(this.selectedTerms['Country'])){
                            let formData = new FormData();
                            for (const term in this.selectedTerms) {
                                if (this.selectedTerms.hasOwnProperty(term) && term == 'Country') { 
                                    if(Array.isArray(this.selectedTerms[term])){
                                        this.selectedTerms[term].forEach(id => {
                                            formData.append('terms[' + id + ']' , id);
                                        });
                                    }
                                }
                            }
                            
                            RequestLink = this.CreateRequestLink(action = 'CaasifyGetRecomPlansForContinent');
                            response = await axios.post(RequestLink, formData);
                        }

                        if (response?.data?.message) {
                            this.recomPlansAreLoading = false;
                            this.recomPlansAreLoaded = true;
                            console.error('Recom Plans Error: ' + response?.data?.message);
                            this.noRecomPlanToShow = true
                        }

                        if (response?.data?.data) {
                            this.recomPlansAreLoading = false;
                            this.recomPlansAreLoaded = true;
                            this.noRecomPlanToShow = false
                            this.recomPlans = response?.data?.data
                        }
                    } else {
                        this.noNeedToRecom = true
                    }
                }
            }
        
        },

        ColorizeRange(event) {
            let percentage = 0
            let currentValue = parseFloat(this.selectedRanges[event.target.id])
            
            let max = null
            this.FilterTerms.forEach(terms => {
                if(terms.name == event.target.id){
                    max = terms.terms[terms.terms.length-1].name
                    max = parseFloat(max)
                }
            });
            
            if(max == null || currentValue == 0){
                percentage = 0
            } else {
                percentage = (currentValue / max) * 100 - 1;
            }
            
            if(event.target.id == 'Traffic' && this.onlyUnlimitedTrafficCheckbox == true) {
                percentage = 0
            }

            if(event.target.id == 'Traffic' && currentValue == 0) {
                percentage = 0
            }
            
            if(event.target.id == 'CPU') {
                percentage -= 5
            }            
            event.target.style.setProperty('--val', percentage);
        },

        loadRange(){
            const cpuRange = document.getElementById('CPU');
            this.ColorizeRange({ target: cpuRange }, 'CPU');
            
            const ramRange = document.getElementById('Ram');
            this.ColorizeRange({ target: ramRange }, 'Ram');
            
            const diskRange = document.getElementById('Disk');
            this.ColorizeRange({ target: diskRange }, 'Disk');

            const trafficRange = document.getElementById('Traffic');
            this.ColorizeRange({ target: trafficRange }, 'Traffic');
        },

        resetTheFilters(){
            this.selectedTerms = {}
            this.selectedTremsWithType = {}  
            
            for (const checkbox in this.checkBoxesStatus) {
                delete this.checkBoxesStatus[checkbox]
            }
            
            this.selectedRanges = {"CPU":"1","Disk":"10","Ram":"1","Traffic":"0"}
            this.loadRange()
        },

        selectedTermsSave(){
            this.loadPlansFromFiltersTerm()
            this.loadRecommendedPlansForContinent()
            this.SelectedPlan = null
            this.PlanSections = null
        },

        findFavoriteTermId(){
            this.FilterTerms.forEach(term => {
                if(term.name == 'favorite'){
                    return term.id
                }
            });
        },

        setSelectedCheckbox(event, type){
            let id = event.target.value
            let status = event.target.checked
            if (!this.selectedTremsWithType[type]) {
                this.selectedTremsWithType[type] = [];
            }
            
            if (status == true){
                this.selectedTremsWithType[type].push(id)
            } else {
                let where = this.selectedTremsWithType[type].indexOf(id);
                if (where != -1) {
                    this.selectedTremsWithType[type].splice(where, 1);
                }
            }
        },

        setSelectedRange(type, CurrentValue){
            let newArrOfTermsToFilter = {}
            if(this.findTermsIdForFiltering(type, CurrentValue) != false){
                newArrOfTermsToFilter[type] = this.findTermsIdForFiltering(type, CurrentValue)
            }
            this.selectedTremsWithType[type] = newArrOfTermsToFilter[type]
        },

        findTermsIdForFiltering(type, CurrentValue){
            // type can be CPU, Ram, Disk, Traffic
            const FilterTerms = this.FilterTerms
            let thisTypeTerms = []
            FilterTerms.forEach(item => {
                if (item.name == type){
                    thisTypeTerms = item.terms
                }
            });
            
            let findIndex = null
            
            thisTypeTerms.forEach((item, index) => {
                if (item.name == CurrentValue){
                    findIndex = index
                }
            });
            
            if(findIndex == 0){
                return false
            }

            if(findIndex == null){
                console.warn('Index is null');
                return false
            }

            let arrOfTermsToFilter = [];
            for (let i = findIndex; i < thisTypeTerms.length ; i++) {
                arrOfTermsToFilter.push(thisTypeTerms[i].id);
            }
            
            return arrOfTermsToFilter
        },

        findUnlimitedTrafficId(){
            this.FilterTerms.forEach(terms => {
                if(terms?.name == 'Traffic'){
                    id = terms?.terms[0]?.id
                }
            });

            if(id != null){
                return id
            } else {
                return null
            }
        },
        
        isSuggested(plan){
            if(plan.hasOwnProperty('suggested')){
                return true
            }
            return false
        },
        
        isSpot(plan){
            if(plan?.detail?.vm_type.toLowerCase() == 'spot'){
                return true
            }
            return false
        },

        isAvailableByCapacity(plan){
            
            if(plan.capacity == null){
                return true
            } else if (plan.capacity.available == true){
                return true
            } else {
                return false
            }
            console.log(plan.capacity);
        },

        createIconAddr(name){
            return '/modules/addons/caasify/views/view/includes/assets/img/services/' + name
        },
    }
});

app.config.compilerOptions.isCustomElement = tag => tag === 'btn'
app.config.devtools = true;
app.mount('#app') 