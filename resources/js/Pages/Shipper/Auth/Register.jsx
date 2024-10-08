import React, { useEffect, useState } from 'react';
import { useForm } from '@inertiajs/inertia-react';
import { Helmet } from 'react-helmet';
import { ToastContainer, toast } from 'react-toastify';
import { FaEye, FaEyeSlash } from 'react-icons/fa';
import Select from '../Components/Form/Select';
import axios from 'axios';

import banner from '../images/register.jpg';

import 'react-toastify/dist/ReactToastify.css';

const Register = ({ flash, title }) => {
    const { data, setData, processing, errors, post } = useForm({
        business_name: '',
        vat_no: '',
        email: '',
        phone: '',
        state: '',
        district: '',
        localbody: '',
        street_address: '',
        ward_no: '',
        password: '',
        password_confirmation: '',
        marketing_accept: false,
    });

    const [showPassword, setShowPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);

    const [stateOptions, setStateOptions] = useState([]);
    const [districtOptions, setDistrictOptions] = useState([]);
    const [localBodyOptions, setLocalBodyOptions] = useState([]);


    useEffect(() => {

        if (flash.error) {
            toast.dismiss();
            toast.error(flash.error);
        }
        if (flash.success) {
            toast.dismiss();
            toast.success(flash.success);
        }
    }, [flash]);

    useEffect(() => {
        axios.get('/shipper/location/states').then((res) => {
            setStateOptions(res.data);
        });
    }, []);

    const handleStateChange = (e) => {
        setData('state', e.target.value);
        axios.get(`/shipper/location/districts?state_id=${e.target.value}`).then((res) => {
            setDistrictOptions(res.data);
        });
    }

    const handleDistrictChange = (e) => {
        setData('district', e.target.value);
        axios.get(`/shipper/location/local-bodies?district_id=${e.target.value}`).then((res) => {
            setLocalBodyOptions(res.data);
        });
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/shipper/register', {
            onSuccess: (data) => {
                console.log('success clear FORM', data);
                setData({
                    business_name: '',
                    vat_no: '',
                    email: '',
                    phone: '',
                    state: '',
                    district: '',
                    localbody: '',
                    street_address: '',
                    ward_no: '',
                    password: '',
                    password_confirmation: '',
                    marketing_accept: false
                });
            },
            onError: (errors) => {
                console.error('Submission failed:', errors);
            }
        });
        console.log(data);
    }

    const inputStyle = "peer border-none bg-transparent p-2 placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0";
    const labelStyle = "pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs";
    const containerStyle = "relative block rounded-md border border-gray-200 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600";

    return (
        <section className="bg-white">
            <Helmet>
                <title>{title}</title>
                <meta name="description" content="This is an example page description." />
                <meta name="keywords" content="example, inertia, react" />
            </Helmet>
            <div className="lg:grid lg:min-h-screen lg:grid-cols-12">
                <section className="relative flex h-32 items-end bg-gray-900 lg:col-span-5 lg:h-full xl:col-span-6">
                    <img
                        alt=""
                        src={banner}
                        className="absolute inset-0 h-full w-full object-cover opacity-80"
                    />

                    <div className="hidden lg:relative lg:block lg:p-12">
                        <a className="block text-white" href="#">
                            <span className="sr-only">Home</span>
                            <svg
                                className="h-8 sm:h-10"
                                viewBox="0 0 28 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M0.41 10.3847C1.14777 7.4194 2.85643 4.7861 5.2639 2.90424C7.6714 1.02234 10.6393 0 13.695 0C16.7507 0 19.7186 1.02234 22.1261 2.90424C24.5336 4.7861 26.2422 7.4194 26.98 10.3847H25.78C23.7557 10.3549 21.7729 10.9599 20.11 12.1147C20.014 12.1842 19.9138 12.2477 19.81 12.3047H19.67C19.5662 12.2477 19.466 12.1842 19.37 12.1147C17.6924 10.9866 15.7166 10.3841 13.695 10.3841C11.6734 10.3841 9.6976 10.9866 8.02 12.1147C7.924 12.1842 7.8238 12.2477 7.72 12.3047H7.58C7.4762 12.2477 7.376 12.1842 7.28 12.1147C5.6171 10.9599 3.6343 10.3549 1.61 10.3847H0.41ZM23.62 16.6547C24.236 16.175 24.9995 15.924 25.78 15.9447H27.39V12.7347H25.78C24.4052 12.7181 23.0619 13.146 21.95 13.9547C21.3243 14.416 20.5674 14.6649 19.79 14.6649C19.0126 14.6649 18.2557 14.416 17.63 13.9547C16.4899 13.1611 15.1341 12.7356 13.745 12.7356C12.3559 12.7356 11.0001 13.1611 9.86 13.9547C9.2343 14.416 8.4774 14.6649 7.7 14.6649C6.9226 14.6649 6.1657 14.416 5.54 13.9547C4.4144 13.1356 3.0518 12.7072 1.66 12.7347H0V15.9447H1.61C2.39051 15.924 3.154 16.175 3.77 16.6547C4.908 17.4489 6.2623 17.8747 7.65 17.8747C9.0377 17.8747 10.392 17.4489 11.53 16.6547C12.1468 16.1765 12.9097 15.9257 13.69 15.9447C14.4708 15.9223 15.2348 16.1735 15.85 16.6547C16.9901 17.4484 18.3459 17.8738 19.735 17.8738C21.1241 17.8738 22.4799 17.4484 23.62 16.6547ZM23.62 22.3947C24.236 21.915 24.9995 21.664 25.78 21.6847H27.39V18.4747H25.78C24.4052 18.4581 23.0619 18.886 21.95 19.6947C21.3243 20.156 20.5674 20.4049 19.79 20.4049C19.0126 20.4049 18.2557 20.156 17.63 19.6947C16.4899 18.9011 15.1341 18.4757 13.745 18.4757C12.3559 18.4757 11.0001 18.9011 9.86 19.6947C9.2343 20.156 8.4774 20.4049 7.7 20.4049C6.9226 20.4049 6.1657 20.156 5.54 19.6947C4.4144 18.8757 3.0518 18.4472 1.66 18.4747H0V21.6847H1.61C2.39051 21.664 3.154 21.915 3.77 22.3947C4.908 23.1889 6.2623 23.6147 7.65 23.6147C9.0377 23.6147 10.392 23.1889 11.53 22.3947C12.1468 21.9165 12.9097 21.6657 13.69 21.6847C14.4708 21.6623 15.2348 21.9135 15.85 22.3947C16.9901 23.1884 18.3459 23.6138 19.735 23.6138C21.1241 23.6138 22.4799 23.1884 23.62 22.3947Z"
                                    fill="currentColor"
                                />
                            </svg>
                        </a>

                        <h2 className="mt-6 text-2xl font-bold text-white sm:text-3xl md:text-4xl">
                            Welcome to Shipper Registration 🚚
                        </h2>

                        <p className="mt-4 leading-relaxed text-white/90">
                            Join our platform to streamline your shipping operations and connect with reliable carriers.
                        </p>
                    </div>
                </section>

                <main className="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6">
                    <div className="max-w-xl lg:max-w-3xl">
                        <div className="relative -mt-16 block lg:hidden">
                            <a
                                className="inline-flex size-16 items-center justify-center rounded-full bg-white text-blue-600 sm:size-20"
                                href="#"
                            >
                                <span className="sr-only">Home</span>
                                <svg
                                    className="h-8 sm:h-10"
                                    viewBox="0 0 28 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M0.41 10.3847C1.14777 7.4194 2.85643 4.7861 5.2639 2.90424C7.6714 1.02234 10.6393 0 13.695 0C16.7507 0 19.7186 1.02234 22.1261 2.90424C24.5336 4.7861 26.2422 7.4194 26.98 10.3847H25.78C23.7557 10.3549 21.7729 10.9599 20.11 12.1147C20.014 12.1842 19.9138 12.2477 19.81 12.3047H19.67C19.5662 12.2477 19.466 12.1842 19.37 12.1147C17.6924 10.9866 15.7166 10.3841 13.695 10.3841C11.6734 10.3841 9.6976 10.9866 8.02 12.1147C7.924 12.1842 7.8238 12.2477 7.72 12.3047H7.58C7.4762 12.2477 7.376 12.1842 7.28 12.1147C5.6171 10.9599 3.6343 10.3549 1.61 10.3847H0.41ZM23.62 16.6547C24.236 16.175 24.9995 15.924 25.78 15.9447H27.39V12.7347H25.78C24.4052 12.7181 23.0619 13.146 21.95 13.9547C21.3243 14.416 20.5674 14.6649 19.79 14.6649C19.0126 14.6649 18.2557 14.416 17.63 13.9547C16.4899 13.1611 15.1341 12.7356 13.745 12.7356C12.3559 12.7356 11.0001 13.1611 9.86 13.9547C9.2343 14.416 8.4774 14.6649 7.7 14.6649C6.9226 14.6649 6.1657 14.416 5.54 13.9547C4.4144 13.1356 3.0518 12.7072 1.66 12.7347H0V15.9447H1.61C2.39051 15.924 3.154 16.175 3.77 16.6547C4.908 17.4489 6.2623 17.8747 7.65 17.8747C9.0377 17.8747 10.392 17.4489 11.53 16.6547C12.1468 16.1765 12.9097 15.9257 13.69 15.9447C14.4708 15.9223 15.2348 16.1735 15.85 16.6547C16.9901 17.4484 18.3459 17.8738 19.735 17.8738C21.1241 17.8738 22.4799 17.4484 23.62 16.6547ZM23.62 22.3947C24.236 21.915 24.9995 21.664 25.78 21.6847H27.39V18.4747H25.78C24.4052 18.4581 23.0619 18.886 21.95 19.6947C21.3243 20.156 20.5674 20.4049 19.79 20.4049C19.0126 20.4049 18.2557 20.156 17.63 19.6947C16.4899 18.9011 15.1341 18.4757 13.745 18.4757C12.3559 18.4757 11.0001 18.9011 9.86 19.6947C9.2343 20.156 8.4774 20.4049 7.7 20.4049C6.9226 20.4049 6.1657 20.156 5.54 19.6947C4.4144 18.8757 3.0518 18.4472 1.66 18.4747H0V21.6847H1.61C2.39051 21.664 3.154 21.915 3.77 22.3947C4.908 23.1889 6.2623 23.6147 7.65 23.6147C9.0377 23.6147 10.392 23.1889 11.53 22.3947C12.1468 21.9165 12.9097 21.6657 13.69 21.6847C14.4708 21.6623 15.2348 21.9135 15.85 22.3947C16.9901 23.1884 18.3459 23.6138 19.735 23.6138C21.1241 23.6138 22.4799 23.1884 23.62 22.3947Z"
                                        fill="currentColor"
                                    />
                                </svg>
                            </a>

                            <h1 className="mt-2 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">
                                Welcome to Shipper Registration 🚚
                            </h1>

                            <p className="mt-4 leading-relaxed text-gray-500">
                                Join our platform to streamline your shipping operations and connect with reliable carriers.
                            </p>
                        </div>

                        <form onSubmit={handleSubmit} className="mt-8 grid grid-cols-6 gap-6">
                            <div className="col-span-6 sm:col-span-3">
                                <label
                                    htmlFor="BusinessName"
                                    className={containerStyle}
                                >
                                    <input
                                        type="text"
                                        id="BusinessName"
                                        name="business_name"
                                        className={`${inputStyle} ${errors.business_name ? 'border-red-500' : ''}`}
                                        placeholder="Laxmi Transport LLC"
                                        value={data.business_name}
                                        onChange={(e) => setData('business_name', e.target.value)}
                                    />
                                    <span className={labelStyle}>
                                        Business Name
                                    </span>
                                </label>
                                {errors.business_name && <p className="mt-2 text-sm text-red-600">{errors.business_name}</p>}
                            </div>

                            <div className="col-span-6 sm:col-span-3">
                                <label
                                    htmlFor="VatNo"
                                    className={containerStyle}
                                >
                                    <input
                                        type="text"
                                        id="VatNo"
                                        name="vat_no"
                                        className={`${inputStyle} ${errors.vat_no ? 'border-red-500' : ''}`}
                                        placeholder="VAT No"
                                        value={data.vat_no}
                                        onChange={(e) => setData('vat_no', e.target.value)}
                                    />
                                    <span className={labelStyle}>
                                        VAT No
                                    </span>
                                </label>
                                {errors.vat_no && <p className="mt-2 text-sm text-red-600">{errors.vat_no}</p>}
                            </div>

                            <div className="col-span-6">
                                <label
                                    htmlFor="Email"
                                    className={containerStyle}
                                >
                                    <input
                                        type="email"
                                        id="Email"
                                        name="email"
                                        className={`${inputStyle} ${errors.email ? 'border-red-500' : ''}`}
                                        placeholder="Email"
                                        value={data.email}
                                        onChange={(e) => setData('email', e.target.value)}
                                    />
                                    <span className={labelStyle}>
                                        Email
                                    </span>
                                </label>
                                {errors.email && <p className="mt-2 text-sm text-red-600">{errors.email}</p>}
                            </div>

                            <div className="col-span-6">
                                <label
                                    htmlFor="Phone"
                                    className={containerStyle}
                                >
                                    <input
                                        type="tel"
                                        id="Phone"
                                        name="phone"
                                        className={`${inputStyle} ${errors.phone ? 'border-red-500' : ''}`}
                                        placeholder="Phone No."
                                        value={data.phone}
                                        onChange={(e) => setData('phone', e.target.value)}
                                    />
                                    <span className={labelStyle}>
                                        Phone No.
                                    </span>
                                </label>
                                {errors.phone && <p className="mt-2 text-sm text-red-600">{errors.phone}</p>}
                            </div>

                            <div className="col-span-6 sm:col-span-2">
                                <label
                                    htmlFor="State"
                                    className={containerStyle}
                                >
                                    <Select
                                        options={stateOptions}
                                        value={data.state}
                                        onChange={handleStateChange}
                                        placeholder="Select State"
                                        className={errors.state ? 'border-red-500' : ''}
                                    />

                                    <span className={labelStyle}>
                                        State
                                    </span>
                                </label>
                                {errors.state && <p className="mt-2 text-sm text-red-600">{errors.state}</p>}
                            </div>

                            <div className="col-span-6 sm:col-span-2">
                                <label
                                    htmlFor="District"
                                    className={containerStyle}
                                >
                                    <Select
                                        options={districtOptions}
                                        value={data.district}
                                        onChange={handleDistrictChange}
                                        placeholder="Select District"
                                        className={errors.district ? 'border-red-500' : ''}
                                    />

                                    <span className={labelStyle}>
                                        District
                                    </span>
                                </label>
                                {errors.district && <p className="mt-2 text-sm text-red-600">{errors.district}</p>}
                            </div>

                            <div className="col-span-6 sm:col-span-2">
                                <label
                                    htmlFor="Localbody"
                                    className={containerStyle}
                                >
                                    <Select
                                        options={localBodyOptions}
                                        value={data.localbody}
                                        onChange={(e) => setData('localbody', e.target.value)}
                                        placeholder="Select Local Body"
                                        className={errors.localbody ? 'border-red-500' : ''}
                                    />
                                    <span className={labelStyle}>
                                        Local Body
                                    </span>
                                </label>
                                {errors.localbody && <p className="mt-2 text-sm text-red-600">{errors.localbody}</p>}
                            </div>

                            <div className="col-span-6 sm:col-span-4">
                                <label
                                    htmlFor="StreetAddress"
                                    className={containerStyle}
                                >
                                    <input
                                        type="text"
                                        id="StreetAddress"
                                        name="street_address"
                                        className={`${inputStyle} ${errors.street_address ? 'border-red-500' : ''}`}
                                        placeholder="Street Address"
                                        value={data.street_address}
                                        onChange={(e) => setData('street_address', e.target.value)}
                                    />
                                    <span className={labelStyle}>
                                        Street Address
                                    </span>
                                </label>
                                {errors.street_address && <p className="mt-2 text-sm text-red-600">{errors.street_address}</p>}
                            </div>

                            <div className="col-span-6 sm:col-span-2">
                                <label
                                    htmlFor="WardNo"
                                    className={containerStyle}
                                >
                                    <input
                                        type="text"
                                        id="WardNo"
                                        name="ward_no"
                                        className={`${inputStyle} ${errors.ward_no ? 'border-red-500' : ''}`}
                                        placeholder="Ward No"
                                        value={data.ward_no}
                                        onChange={(e) => setData('ward_no', e.target.value)}
                                    />
                                    <span className={labelStyle}>
                                        Ward No
                                    </span>
                                </label>
                                {errors.ward_no && <p className="mt-2 text-sm text-red-600">{errors.ward_no}</p>}
                            </div>

                            <div className="col-span-6 sm:col-span-3 relative">
                                <label
                                    htmlFor="Password"
                                    className={containerStyle}
                                >
                                    <input
                                        type={showPassword ? "text" : "password"}
                                        id="Password"
                                        name="password"
                                        className={`${inputStyle} pr-10 ${errors.password ? 'border-red-500' : ''}`}
                                        placeholder="Password"
                                        value={data.password}
                                        onChange={(e) => setData('password', e.target.value)}
                                    />
                                    <span className={labelStyle}>
                                        Password
                                    </span>
                                    <button
                                        type="button"
                                        className="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        onClick={() => setShowPassword(!showPassword)}
                                    >
                                        {showPassword ? (
                                            <FaEyeSlash className="h-5 w-5 text-gray-400" />
                                        ) : (
                                            <FaEye className="h-5 w-5 text-gray-400" />
                                        )}
                                    </button>
                                </label>
                                {errors.password && <p className="mt-2 text-sm text-red-600">{errors.password}</p>}
                            </div>

                            <div className="col-span-6 sm:col-span-3 relative">
                                <label
                                    htmlFor="PasswordConfirmation"
                                    className={containerStyle}
                                >
                                    <input
                                        type={showConfirmPassword ? "text" : "password"}
                                        id="PasswordConfirmation"
                                        name="password_confirmation"
                                        className={`${inputStyle} pr-10 ${errors.password_confirmation ? 'border-red-500' : ''}`}
                                        placeholder="Password Confirmation"
                                        value={data.password_confirmation}
                                        onChange={(e) => setData('password_confirmation', e.target.value)}
                                    />
                                    <span className={labelStyle}>
                                        Password Confirmation
                                    </span>
                                    <button
                                        type="button"
                                        className="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                                    >
                                        {showConfirmPassword ? (
                                            <FaEyeSlash className="h-5 w-5 text-gray-400" />
                                        ) : (
                                            <FaEye className="h-5 w-5 text-gray-400" />
                                        )}
                                    </button>
                                </label>
                                {errors.password_confirmation && <p className="mt-2 text-sm text-red-600">{errors.password_confirmation}</p>}
                            </div>

                            <div className="col-span-6">
                                <label htmlFor="MarketingAccept" className="flex gap-4">
                                    <input
                                        type="checkbox"
                                        id="MarketingAccept"
                                        name="marketing_accept"
                                        className={`size-5 rounded-md border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 ${errors.marketing_accept ? 'border-red-500' : ''}`}
                                        checked={data.marketing_accept}
                                        onChange={(e) => setData('marketing_accept', e.target.checked)}
                                    />
                                    <span className="text-sm text-gray-700">
                                        I want to receive emails about events, product updates and company announcements.
                                    </span>
                                </label>
                                {errors.marketing_accept && <p className="mt-2 text-sm text-red-600">{errors.marketing_accept}</p>}
                            </div>

                            <div className="col-span-6">
                                <p className="text-sm text-gray-500">
                                    By creating an account, you agree to our
                                    <a href="#" className="text-gray-700 underline"> terms and conditions </a>
                                    and
                                    <a href="#" className="text-gray-700 underline"> privacy policy</a>.
                                </p>
                            </div>

                            <div className="col-span-6 sm:flex sm:items-center sm:gap-4">
                                <button
                                    className="inline-block shrink-0 rounded-md border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500"
                                    type="submit"
                                    disabled={processing}
                                >
                                    Create an account
                                </button>

                                <p className="mt-4 text-sm text-gray-500 sm:mt-0">
                                    Already have an account?
                                    <a href="#" className="text-gray-700 underline">Log in</a>.
                                </p>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
            <ToastContainer />
        </section>
    );
};

export default Register;