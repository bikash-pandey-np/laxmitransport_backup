import React, { useState, useEffect, useRef } from 'react';
import { Link } from '@inertiajs/inertia-react';
import { usePage } from '@inertiajs/inertia-react';
import { ToastContainer, toast } from 'react-toastify';
import Swal from 'sweetalert2';
import { Inertia } from '@inertiajs/inertia';
import { FaHome, FaQuoteRight, FaShippingFast, FaTruck, FaUserCircle, FaCog, FaSignOutAlt } from 'react-icons/fa';
import { RiMenuLine } from 'react-icons/ri';
import 'react-toastify/dist/ReactToastify.css';
import 'sweetalert2/dist/sweetalert2.min.css';

const Layout = ({ children }) => {
    const { flash, auth_name } = usePage().props;

    const [isOpen, setIsOpen] = useState(false);
    const [isProfileOpen, setIsProfileOpen] = useState(false);
    const profileRef = useRef(null);

    const toggleMenu = () => setIsOpen(!isOpen);
    const toggleProfile = () => setIsProfileOpen(!isProfileOpen);

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (profileRef.current && !profileRef.current.contains(event.target)) {
                setIsProfileOpen(false);
            }
        };

        console.log('flash useEffect',flash);

        if(flash.success){
            toast.dismiss();
            toast.success(flash.success);
        }
        if(flash.error){
            toast.dismiss();
            toast.error(flash.error);
        }



        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

    const handleLogout = (e) => {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!'
        }).then((result) => {   
            if (result.isConfirmed) {
                Inertia.post('/shipper/logout');
            }
        });
    }

    const menuItems = [
        { name: 'Dashboard', icon: <FaHome />, href: '/shipper/dashboard' },
        { name: 'Quotes', icon: <FaQuoteRight />, href: '/shipper/quote' },
        { name: 'In Progress', icon: <FaShippingFast />, href: '/shipper/in-progress' },
        { name: 'Shipments', icon: <FaTruck />, href: '/shipper/shipments' },
    ];

    return (
        <div className="min-h-screen bg-gray-100">

            <nav className="bg-indigo-600 shadow-lg">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex-shrink-0 flex items-center">
                            <Link href="/shipper/dashboard" className="text-white font-bold text-xl">
                                Our Logo
                            </Link>
                        </div>
                        <div className="hidden sm:ml-6 sm:flex sm:items-center">
                            {menuItems.map((item) => (
                                <Link
                                    key={item.name}
                                    href={item.href}
                                    className="text-gray-300 hover:bg-indigo-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center"
                                >
                                    <span className="mr-2">{item.icon}</span>
                                    {item.name}
                                </Link>
                            ))}
                            <div className="ml-3 relative" ref={profileRef}>
                                <div>
                                    <button
                                        onClick={toggleProfile}
                                        className="flex items-center text-sm px-4 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white"
                                    >
                                        <span className="sr-only">Open user menu</span>
                                        <div className="flex items-center">
                                            <FaUserCircle className="h-8 w-8 text-white" />
                                            <span className="text-white ml-2">{auth_name}</span>
                                        </div>
                                    </button>
                                </div>
                                {isProfileOpen && (
                                    <div className="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5">
                                        <Link href="/shipper/profile" className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <FaUserCircle className="inline-block mr-2" /> Manage Profile
                                        </Link>
                                        <Link href="/shipper/settings" className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <FaCog className="inline-block mr-2" /> Settings
                                        </Link>
                                        <Link onClick={handleLogout} className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <FaSignOutAlt className="inline-block mr-2" /> Logout
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>
                        <div className="-mr-2 flex items-center sm:hidden">
                            <button
                                onClick={toggleMenu}
                                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            >
                                <span className="sr-only">Open main menu</span>
                                <RiMenuLine className="block h-6 w-6" />
                            </button>
                        </div>
                    </div>
                </div>
                {isOpen && (
                    <div className="sm:hidden">
                        <div className="px-2 pt-2 pb-3 space-y-1">
                            {menuItems.map((item) => (
                                <Link
                                    key={item.name}
                                    href={item.href}
                                    className="text-gray-300 hover:bg-indigo-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
                                >
                                    <div className="flex items-center">
                                        <span className="mr-2">{item.icon}</span>
                                        {item.name}
                                    </div>
                                </Link>
                            ))}
                            <Link href="/shipper/profile" className="text-gray-300 hover:bg-indigo-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                                <div className="flex items-center">
                                    <FaUserCircle className="mr-2" /> Manage Profile
                                </div>
                            </Link>
                            <Link href="/shipper/settings" className="text-gray-300 hover:bg-indigo-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                                <div className="flex items-center">
                                    <FaCog className="mr-2" /> Settings
                                </div>
                            </Link>
                            <Link onClick={handleLogout} className="text-gray-300 hover:bg-indigo-700 hover:text-white block w-full text-left px-3 py-2 rounded-md text-base font-medium">
                                <div className="flex items-center">
                                    <FaSignOutAlt className="mr-2" /> Logout
                                </div>
                            </Link>
                        </div>
                    </div>
                )}
            </nav>
            <main className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                {children}
            </main>
            <ToastContainer />
        </div>
    );
};

export default Layout;
