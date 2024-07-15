
let messages = {
    
}

let errors = {
    
}

let common = {
// order view 
        
        // from product
        "download" : "Download",
        "upload" : "Upload",
        "backtoservices" : "Voltar para Serviços",
        "ghz" : "GHz",
        "mb" : "MB",
        "gb" : "GB",
        "core" : "Núcleo",
        "hostname" : "Hostname : ",
        "pending" : "Pendente",
        "processing" : "Processando",
        "active" : "Ativo",
        "passive" : "Passivo",
        "online" : "Online",
        "offline" : "Offline",
        "memory" : "MEMÓRIA",
        "disk" : "DISCO",
        "cpu" : "CPU",
        "template" : "MODELO",
        "uptime" : "TEMPO DE ATIVIDADE",
        "and" : " e ",
        "days" : "Dia",
        "hours" : "Hora",
        "minutes" : "Minutos",
        "finance" : "Finanças",
        "servicesname" : "Nome dos Serviços",
        "registrationdate" : "Data de Registro :",
        "nextpayment" : "Próximo Pagamento :",
        "billingcycle" : "Ciclo de Cobrança :",
        "networkinformation": "Informações de Rede",
        "ipaddress": "Endereço IP :",
        "networkstatus": "Status de Rede :",
        "connected": "Conectado",
        "disconnected": "Desconectado",
        "login": "Login",
        "username": "Nome de Usuário",
        "password": "Senha",
        "rebootaction": "Reiniciar",
        "stopaction": "Parar",
        "consoleaction": "Console",
        "startaction": "Iniciar",

        "rebooting": "Reiniciando ...!",
        "stoping": "Parando ...!",
        "consoleing": "Procurando Console ...!",
        "starting": "Iniciando ...!",

        "access": "Acesso",
        "accesstext": "Aqui estão informações e ferramentas para gerenciar sua VM.",
        "changeos": "Mudar SO",
        "network": "Rede",
        "upgrades": "Atualizações",

        "events": "Eventos",
        "statistics": "Estatísticas",
        "sshkey": "Chave SSH",
        "status": "Status",
        "beginingat": "Início em",
        "endingat": "Término em",
        "completed": "Concluído",

        "cancelled": "Cancelado",
        "loadingmsg": "Carregando",
        "loadingmsglong": "Tentar buscar dados do servidor pode levar alguns segundos.",
        "iplists": "Listas de IP",
        "gateway": "Gateway",
        "netmask": "Máscara de Rede",
        "orderip": "Solicitar IP",

        "currentkey": "Chave Atual: ",
        "upgradecloud": "Atualizar Servidor na Nuvem",
        "setup": "Configuração",
        "waittofetch": "Aguarde, pode levar alguns segundos para buscar todos os dados ... !",
        "lastactionpending" : "Sua última ação ainda está pendente ... !",

        "waitforsetup" : "Aguarde a configuração ser concluída ... !",
        "orderisinstalling" : "Sua máquina está instalando ",
        "dontclose" : "Por favor, não feche esta janela e aguarde a configuração ser concluída ... !",
        "willtake" : "Levará alguns minutos",
        "goingtoinstall" : "Você está prestes a instalar",
        "onyourorder" : "em sua máquina!",
        "installationalert" : "Durante a instalação, você perderá permanentemente todos os seus dados.",
        "destroyalert" : "Ao destruir, você perderá permanentemente todos os seus dados.",
        "clearandinstall" : "Limpar e Instalar",
        "alert" : "Alerta",
        "installing" : "Instalando",

        "installedsuccessfully" : "foi instalado com sucesso!",
        "accountinformation" : "Aqui estão suas informações de conta:",
        "lastaction" : "Última Ação : ",
        "close" : "Fechar",
        "thiscommand" : "Este comando pode levar algum tempo. Por favor, seja paciente",

        "goingto" : "Você está prestes a ",
        "yourorder" : "sua máquina!",
        "requestgetlink" : "Você solicitou obter um link para o seu Console.",
        "yourcommand" : "Seu comando, ",
        "hasdonesuccessfully" : "foi realizado com sucesso",
        "accessconsole" : "Você pode acessar seu console através do seguinte link.",
        "openconsole" : "Abrir Console",

        "confirmtext" : "Você tem certeza disso?",
        "currentaction" : "Ação Atual : ",

        "chooselanguage" : "Escolha o idioma",
        "english" : "Inglês",
        "farsi" : "Farsi",
        "turkish" : "Turco",
        "french" : "Francês",
        "deutsch" : "Alemão",
        "russian" : "Russo",

        "setlanguage" : "Definir Idioma",
        "traffics" : "Informações de Tráfego",
        "buytraffics" : "Comprar",
        "tabeltraffic" : "Tráfego: ",
        "traffictype" : "Tipo: ",
        "trafficusage" : "Uso de Tráfego: ",
        "trafficdate" : "Ponto de Início: ",
        "main" : "Principal",
        "plus" : "Extra",

        "actionstatuscompleted" : "Concluído",
        "actionstatuspending" : "Pendente",
        "actionstatusprocessing" : "Processando",

        "fetchingalert" : "Buscando Informações",
        "nothingeheader" : "Ops!",
        "nothingtoseetext" : "Não recebemos nenhuma informação do servidor. Não há nada para mostrar!",
        "software" : "Instalar Software",
        "install" : "Instalar",
        "consolefailed" : "Há um problema com o link do console, por favor, tente novamente",
        'failed' : 'Falhou',
        "consoleisrunningalery" : "O sistema está rodando para preparar o link do console. Pode levar menos de um minuto.",
        "tryagain" : "Tente novamente",
        "sshkeytitle" : "Chave SSH : ",
        "suspend" : "Suspender",
        "unsuspend" : "Reativar",
        "refresh" : "Atualizar",
        "trafficplan" : "Plano de Tráfego",
        "remainingtraffic" : "Tráfego Restante : ",
        "trafficduration" : "Duração :",
        "remainingtime" : "Tempo Restante :",
        "failactionmsg" : "A última ação não foi concluída completamente, o status ainda está falhado, por favor, tente uma nova ação!",
        "snapshot" : "Snapshot",
        "traffic" : "TRAFFIC",

        // end from Product

        // Unique for this cloud
        "todeleteyourorder" : "Para excluir sua máquina, você deve escrever",
        "writedestroy" : "'destroy'",
        "intheboxbelow" : "na caixa abaixo e aguardar alguns segundos",
        "typehere" : "Digite aqui a palavra:",
        "failedmessage" : "Há um problema ao buscar os dados do backend, o status da ação ainda está falho!",
        "error" : "Erro",
        "trafficprice" : "Preço: ",
        "costperhour" : "Custo por Hora : ",
        "cent" : "¢",
        "$" : "$",
        "setupaction": "Configurar SO",
        "destroying": "Destruição",
        "destroyaction": "Destruir",
        "fetching" : "Buscando Dados",
        "payasyougo" : "Pague conforme usar",
        // End Unique for this cloud
// end order View 



// index page
    "clicktoseeadmin" : "Clique para ver a conta do usuário na Nuvem",
    "orderlist" : "Lista de Máquinas",
    "topup" : "Recarregar",
    "listofactiveorders" : "Lista de Máquinas Ativas",
    "noactiveorder" : "Você não possui máquina ativa no momento. Para ter uma, você deve primeiro recarregar sua conta e depois clicar em [Criar Máquina]",
    "address" : "Endereço",
    "hostnameontable" : "Hostname",
    "templateontable" : "Modelo",
    "viewontable" : "Visualizar",
    "statusontable" : "Status",
  

// new charging Module
    "cloudbalance" : "Saldo na Nuvem",
    "actiondidnotsucceed" : "Esta ação não teve sucesso, por favor, recarregue e tente novamente",
    "noaccessinvoice" : "Sem acesso para criar uma fatura.",
    "noaccesscharge" : "A fatura foi criada com sucesso, mas não temos acesso para cobrar o seu saldo. Por favor, tente novamente ou entre em contato com o administrador.",
    "noaccessapply" : "A fatura foi criada com sucesso e cobramos o seu Saldo na Nuvem, mas não temos acesso para pagar automaticamente a sua fatura. Portanto, tente pagar a fatura manualmente.",
    "reload" : "Recarregar",
    "cloudaccount" : "Conta Global na Nuvem",
    "movebalance" : "Mover Saldo",
    "heretocharge" : "Aqui você pode carregar sua Conta na Nuvem",
    "yourcredit" : "Seu crédito",
    "isnotenough" : "não é suficiente, por favor, vá para sua conta e adicione algum crédito primeiro",
    "minimumis" : "O crédito mínimo para carregar sua Conta na Nuvem é",
    "chargecloudaccount" : "Carregar Conta na Nuvem",
    "youcantransfercredit" : "Você pode carregar sua Conta na Nuvem usando o crédito da sua conta. Com esta ação, você transfere o crédito da sua conta para o seu Saldo na Nuvem.",
    "pleaseinputamountmoney" : "Por favor, insira a quantia que deseja carregar em sua Conta na Nuvem, lembre-se de que o valor máximo é o seu crédito.",
    "amounttocharge" : "Quantidade a carregar",
    "donthaveenoughcredit" : "Você não tem crédito suficiente, por favor, adicione algum crédito primeiro",
    "islessthanminimum" : "Seu crédito é menor que o mínimo permitido para carregar. O mínimo é",
    "lessthanalowedminimum" : "Este número de entrada não é válido, é menor que o mínimo permitido para carregar. O mínimo é",
    "notvaliddecimal" : "Este número não é válido, não use decimais",
    "thisismorethancredit" : "Este número é maior do que o seu crédito",
    "youraccountcreditis" : "O crédito da sua conta é",
    "andyouaretransfering" : "e você está prestes a transferir",
    "intoyourbalance" : "para o seu Saldo na Nuvem.",
    "ifyousurealmost" : "Se você tem certeza, por favor, clique no botão para iniciar a transação",
    "pleasedontreload" : "Por favor, não recarregue esta página",
    "starttransferring" : "Iniciar Transferência",
    "step1creatinganinvoice" : "Passo 1: Criando uma Fatura",
    "step2chargethecloudaccount" : "Passo 2: Carregando a Conta na Nuvem",
    "step3payyourinvoice" : "Passo 3: Pague sua Fatura",
    "accountcredit" : "Crédito da Conta",
    "successful" : "Bem-sucedido",
    "chargingdonesuccessfully" : "O processo de carregamento foi concluído com sucesso, por favor, recarregue a página para ver o resultado",
    "currentbalanceautovm" : "Saldo Atual do Caasify",
    "addorremove" : "Adicionar/Remover Saldo ±",
    "increase" : "Aumentar",
    "decrease" : "Diminuir",
    "transid" : "ID da Transação",
    "hasrecordedsuccessfully" : "foi registrado com sucesso",
    "anerroroccurred" : "Ocorreu um erro",
    "cannotfinduserid" : "Erro: Não é possível encontrar o usuário com este ID",
    "useminnuestoreduce" : "Use o sinal de menos ( - ) para reduzir o saldo",
    "ittakesminutes" : "Nota: Leva mais de 30 segundos para ver o resultado do saldo no perfil do usuário.",
    "adjustusebalance" : "Ajustar Saldo do Usuário",
    "maketransaction" : "Record New Transaction",
    "email" : "E-mail",
    "userdetailautovm" : "Detalhes do Usuário no Caasify",
    "taketimetoseeresult" : "Normalmente, leva mais de alguns minutos para ver o carregamento em seu Saldo na Nuvem",
    "noaction" : "Nenhuma Ação Registrada",

// end index




// create order page
    "backtoorderlist" : "Voltar para a Lista de Máquinas",
    "datacenters" : "Centros de Dados * ",
    "chooseregion" : "Escolha a Região do Centro de Dados",
    "products" : "Produtos * ",
    "selectaproduct" : "Selecione um produto desta região",
    "thereisnodatacenter" : "Não há produto na região selecionada",
    "pleaseselect" : "Por favor, selecione um Centro de Dados primeiro na lista acima",
    "bandwidth" : "Largura de Banda : ",
    "operationsystem" : "Sistema Operacional *",
    "selectatemplate" : "Selecione um modelo",
    "nameofhost" : "Hostname *",
    "enteraname" : "Digite um nome para a VM",
    "Addssh" : "Adicionar Chave SSH Pública",
    "extraresource" : "Recurso Extra",
    "orderextra" : "Você pode pedir recursos extras com base em suas necessidades",
    "totalcost" : "Custo Total ",
    "totalcostis" : "O custo total de criar a máquina é ",
    "firstselectone": "Por favor, primeiro selecione um dos produtos acima",
    "createorder" : "Criar Máquina",
    "hourly" : "por hora",
    "cancel": "Cancelar",
    "createthisorder": "Criar Esta Máquina",
    "youarecreating" : "Você está criando uma nova máquina com a seguinte configuração!",
    "makesure" : "Certifique-se de fornecer todas as informações necessárias",
    "notprovideallinformation" : "Você não forneceu todas as informações necessárias",
    "datacentermissed" : "Centro de Dados não informado",
    "productmissed" : "Nome do Produto não informado",
    "templatemissed" : "Modelo não informado",
    "allinfoprovided" : "Todas as informações necessárias foram fornecidas",
    "name" : "Nome : ",
    "datacenter" : "Centro de Dados : ",
    "product" : "Produto : ",
    "producttemplate" : "Modelo : ",
    "sshkeytitle" : "Chave SSH : ",
    "price" : "Preço : ",
    "monthly" : "Mensal",
    "youdidntchoose" : "Você não escolheu nenhuma configuração",
    "entersshkey" : "Insira sua chave SSH aqui.",
    "required" : "Obrigatório ",
    "balance" : "Saldo",
    "orderlink": "Ver a Máquina",
    "ordercreatesuccessfully" : "Máquina criada com sucesso!",
    "currentplan" : "Custo do Plano :",
    "createorderfailed" : "Não foi possível criar sua máquina, por favor, tente novamente. Se isso acontecer novamente, entre em contato conosco para suporte",
    "createanotherorder" : "Criar Outra Máquina",
    "createsuccessmsg": "Agora você pode ver sua máquina na lista de máquinas clicando no link a seguir. Você também pode criar outra máquina",
    "onlyenglishletters": "Apenas letras em inglês",

    "cpucore" : "Núcleo da CPU",
    "cpufrequency" : "Frequência da CPU",
    "configuration" : "Configuração",
    "configinyourfavor" : "Configure este plano a seu favor",
    "pleaseselectaplan" : "Por favor, selecione um Plano primeiro na lista acima",
    "balanceisnotenough" : "Seu saldo não é suficiente para continuar, você deve carregar sua conta primeiro",
    "billsummary" : "Resumo da Fatura",
    "seeyourorderdetails" : "Veja os detalhes do seu pedido",
    "costoneip" : "Custo para um endereço IP",
    "costonegigtraffic" : "Custo para um tráfego de 1 GB",
    "freeprice" : "Grátis",
    "pricestartsfrom" : "O preço começa a partir de",
    "confirmationtext" : "Eu afirmo meu acordo com todos os termos e regulamentos para utilizar a nuvem global da rede.",
    "optional" : "Opcional",
    "readmore" : "Leia Mais ...",

    "nanoconfiguration" : "Nano Configuration",
    "basicconfiguration" : "Basic Configuration",
    "standardconfiguration" : "Standard Configuration",
    "advancedconfiguration" : "Advanced Configuration",
    "enterpriseconfiguration" : "Enterprise Configuration",
    "ipv" : "Internet Protocol version",
    "ipvversion4" : "",
    "ipvversion6" : "",
    "IPV6" : "IPV6",
    "Create Machine" : "Create Machine",
    "createmachinefailed" : "Create Machine Failed",
// create order page


// admin panel
        "usertoken" : "User Token",


    // new CAASIFY
    "Locations" : "Localizações",
    "in" : "em",
    "machinecreatesuccessfully" : "Máquina criada com sucesso",
    "createanothermachine" : "Criar outra máquina",
    "ID" : "ID",
    "Alive" : "Ativo",
    "Price" : "Preço",
    "Views" : "Visualizações",
    "Order is Loading" : "Pedido está carregando",
    "This Order has been deleted" : "Este pedido foi deletado",
    "Product Price" : "Preço do Produto",
    "Action" : "Ação",
    "Time" : "Tempo",
    "Controllers Are Loading" : "Controladores estão carregando",
    "Views Are Loading" : "Visualizações estão carregando",
    "No valid Controller Founded" : "Nenhum controlador válido encontrado",
    "Confirmation" : "Confirmação",
    "You are going to" : "Você vai ",
    "your machine, are you sure ?" : " sua máquina, tem certeza?",
    "Something is in queue !" : "Algo está na fila!",

    "Graphs" : "Gráficos",
    "BackUp" : "Backup",
    "Volume" : "Volume",
    "Resize" : "Redimensionar",
    "Setting" : "Configuração",
    "History" : "Histórico",

    "SETUP" : "CONFIGURAR",
    "START" : "INICIAR",
    "STOP" : "PARAR",
    "REBOOT" : "REINICIAR",
    "DELETE" : "DELETAR",
    "SHOW" : "MOSTRAR",

    "DELIVERED" : "ENTREGUE",
    "FAILED" : "FALHOU",
    "PENDING" : "PENDENTE",

    "Warning" : "Uyarı",
    "MoreThanMax" : "Geçersiz: izin verilen ücretten fazla, yöneticinizi arayın",
    "DeleteIsNotAllowed" : "BU MAKİNEYİ SİLMEK DEMO MODUNDA YASAKTIR",
    "TrafficAlert" : "10 dakikadan fazla sürebilir",
    "Machine Info" : "Makine Bilgisi",




















    // New
    "Cloud Account" : "Conta na Nuvem",
    "InsertValidNumber" : "Para carregar sua conta na nuvem, por favor, insira um número válido",
    "Creating invoice" : "Criando fatura",
    "invoice created successfully" : "fatura criada com sucesso",
    "Go to invoice payment" : "Ir para o pagamento da fatura",
    "Creating invoice Failed, try again" : "Criação da fatura falhou, tente novamente",
    "Inbound" : "Entrada",
    "Outbound" : "Saída",
    "Admin Finance" : "Finanças do Admin",
    "AdminBalance" : "Saldo do Admin (€)",
    "Commission" : "Comissão",
    "User Finance" : "Finanças do Usuário",
    "UserBalanceReal" : "Saldo Real do Usuário (€)",
    "UserBalanceWithCommission" : "Saldo do Usuário com Comissão (€)",
    "Charging" : "Carregando",
    "With Commission" : "Com Comissão",
    "Increase User Balance" : "Aumentar Saldo do Usuário",
    "Decrease User Balance" : "Diminuir Saldo do Usuário",
    "Commission is Wrong" : "Comissão está Errada",
    "User Orders" : "Pedidos do Usuário",
    "User has no active order" : "O usuário não tem pedidos ativos",
    "Error 670: call your admin" : "Erro 670: Comissão inválida",
    "increasebalance" : "Você vai AUMENTAR o saldo",
    "decreasebalance" : "Você vai DIMINUIR o saldo",
    "It is not valid number" : "Não é um número válido",
    "ChargingUserFor" : "Carregando Saldo do Usuário para",
    "DeChargingUserFor" : "Diminuindo Saldo do Usuário para",
    "Charge action has done Successfully" : "Ação de carga realizada com sucesso",
    "headcharge" : "Recarregar o Saldo da Nuvem",
    "euro" : " €",
    "amounttochargewithcommission" : "Valor a carregar com comissão €",
    "amounttochargereal" : "Valor a carregar em Real €",
    "doTransaction" : "Efetuar Transação",
    "BalanceIsLow" : "Seu saldo está baixo",
    "MachienWouldDelete" : "Sua máquina será excluída em breve",
    "hours or less" : "horas ou menos restantes",
    "an hour or less" : "uma hora ou menos restantes",
    "24 hours or less" : "24 horas ou menos restantes",
    "I am aware of the Risk" : "Estou ciente do risco",
    "Confirm Alert and Close" : "Confirmar Alerta e Fechar",
    "SpotAlert01" : "Atenção: VMs Spot são projetadas para cargas de trabalho temporárias e flexíveis e não devem ser usadas para ambientes críticos ou de produção.",
    "SpotAlert02" : "Pontos Chave a Considerar:",
    "SpotAlert03" : "Risco de Preempção:",
    "SpotAlert04" : "VMs Spot podem ser preemptadas (terminadas) pelo provedor de nuvem a qualquer momento quando a capacidade for necessária em outro lugar.",
    "SpotAlert05" : "Sem Garantias:",
    "SpotAlert06" : "Não há garantia de disponibilidade ou tempo de atividade para VMs Spot.",
    "SpotAlert07" : "Melhores Casos de Uso:",
    "SpotAlert08" : "Adequado para processamento em lote, desenvolvimento, teste e outras cargas de trabalho não críticas.",
    "SpotAlert09" : "Para desempenho estável, confiável e garantido, recomendamos escolher as ofertas padrão de VM."    









}

const words = {
    ...messages,
    ...common,
    ...errors
}