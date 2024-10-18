const routes = {
    auth: {
        login: '/shipper/login',
        register: '/shipper/register',
        verifyEmail: '/shipper/verify-email',
        sendVerificationEmail: '/shipper/verify-email/send-email',
        verify: '/shipper/verify',
    },
    dashboard: '/shipper/dashboard',
    quote: '/shipper/quote',
    truckloadQuote: '/shipper/truckload-quote',
    location: {
        states: '/shipper/location/states',
        districts: '/shipper/location/districts',
        localBodies: '/shipper/location/local-bodies',
    },
    logout: '/shipper/logout',
}

export default routes;
