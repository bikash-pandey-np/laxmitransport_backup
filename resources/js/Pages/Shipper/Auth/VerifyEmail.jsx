import React, { useState, useEffect } from 'react';
import Layout from '../Layout';
import { Helmet } from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import { FaEnvelope, FaLock } from 'react-icons/fa';
import { useForm } from '@inertiajs/inertia-react';
import axios from 'axios';
import { toast } from 'react-toastify';

const VerifyEmail = ({email, title, flash}) => {
    const [timer, setTimer] = useState(30); // in seconds
    const [isTimerRunning, setIsTimerRunning] = useState(false);
    const { data, setData, post, processing, errors } = useForm({
        otp: '',
    });

    useEffect(() => {
        const sendEmail = async () => { 
            var response = await axios.post('/shipper/verify-email/send-email', {
                email: email,
            });
            console.log(response.data);

            if(response.data.error){
                toast.error(response.data.message);
            }
            else{
                if(response.data.status == 201){
                    Inertia.visit('/shipper/dashboard');
                }

                if(response.data.status == 200){
                    toast.success(response.data.message);
                    setIsTimerRunning(true);
                }
            }
        }
        sendEmail();
    }, []);

    useEffect(() => {
        let interval;
        if (isTimerRunning && timer > 0) {
            interval = setInterval(() => {
                setTimer((prevTimer) => prevTimer - 1);
            }, 1000);
        } else if (timer === 0) {
            setIsTimerRunning(false);
        }
        return () => clearInterval(interval);
    }, [isTimerRunning, timer]);

    useEffect(() => {
        if(flash.success){
            toast.dismiss();
            toast.success(flash.success);
        }
        if (flash.error) {
            toast.dismiss();
            toast.error(flash.error);
        }
    }, [flash]);

    const handleSubmit = (e) => {
        e.preventDefault();
        // Handle OTP verification logic here
    };

    const handleResendOtp = async () => {
        if (!isTimerRunning) {
            const response = await axios.post('/shipper/verify-email/send-email', {
                email: email,
            });
            if (response.data.status == 200) {
                toast.success(response.data.message);
                setTimer(120);
                setIsTimerRunning(true);
            } else {
                toast.error(response.data.message);
            }
        }
    };

    return (
        <Layout>
            <Helmet>
                <title>{title}</title>
                <meta name="description" content="This is an example page description." />
                <meta name="keywords" content="example, inertia, react" />
            </Helmet>
            <div className="max-w-screen-xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
                <div className="max-w-lg mx-auto">
                    <h1 className="text-2xl font-bold text-center text-indigo-600 sm:text-3xl">Verify Your Email</h1>

                    <p className="mx-auto mt-4 max-w-md text-center text-gray-500">
                        We've sent a verification code to your email. Please enter it below to verify your account.
                    </p>

                    <form onSubmit={handleSubmit} className="mt-6 mb-0 space-y-4 rounded-lg p-8 shadow-2xl">
                        <p className="text-lg font-medium">Enter your verification code</p>

                        <div>
                            <label htmlFor="otp" className="sr-only">OTP</label>

                            <div className="relative">
                                <input
                                    type="text"
                                    id="otp"
                                    className="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm"
                                    placeholder="Enter verification code"
                                    value={data.otp}
                                    onChange={(e) => setData('otp', e.target.value)}
                                />

                                <span className="absolute inset-y-0 end-0 grid place-content-center px-4">
                                    <FaLock className="h-4 w-4 text-gray-400" />
                                </span>
                            </div>
                        </div>

                        <button
                            type="submit"
                            className="block w-full rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white"
                            disabled={processing}
                        >
                            Verify OTP
                        </button>

                        <button
                            type="button"
                            onClick={handleResendOtp}
                            className={`block w-full rounded-lg px-5 py-3 text-sm font-medium ${
                                isTimerRunning
                                    ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                            }`}
                            disabled={isTimerRunning}
                        >
                            {isTimerRunning ? `Resend OTP (${timer}s)` : 'Resend OTP'}
                        </button>
                    </form>
                </div>
            </div>
        </Layout>
    );
};

export default VerifyEmail;
