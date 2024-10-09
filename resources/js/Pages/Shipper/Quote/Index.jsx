import React, { useState } from 'react'
import { useForm } from '@inertiajs/inertia-react'
import Layout from '../Layout';
import { FaPlus } from 'react-icons/fa';

const Index = ({title}) => {
    const [activeTab, setActiveTab] = useState('Parcel');
    const { data, setData, post, processing, errors } = useForm({
        loadType: 'Parcel',
        loadOrigin: '',
        pickupDate: '',
        deliverDestination: '',
        items: []
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        // Handle form submission
    };

    const handleTabChange = (tabName) => {
        setActiveTab(tabName);
        setData('loadType', tabName);
    };

    const TabButton = ({ name, isActive }) => (
        <button
            onClick={() => handleTabChange(name)}
            className={`px-4 py-2 font-semibold rounded-t-lg transition-colors duration-200 ${
                isActive
                    ? 'bg-blue-500 text-white'
                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
            }`}
        >
            {name}
        </button>
    );

    const addItem = () => {
        setData('items', [...data.items, {
            description: '',
            packagingType: '',
            isStackable: 'no',
            quantity: '',
            totalWeight: '',
            length: '',
            width: '',
            height: ''
        }]);
    };

    const updateItem = (index, field, value) => {
        const updatedItems = [...data.items];
        updatedItems[index][field] = value;
        setData('items', updatedItems);
    };

    const packagingTypes = ['Box', 'Pallet', 'Crate', 'Drum', 'Other'];

    return (
        <Layout>
            <h1 className="text-3xl font-bold mb-6 text-center text-blue-600">Create Your Shipment</h1>

            <div className="bg-white shadow-lg rounded-lg p-6 max-w-3xl mx-auto">
                <div className="flex space-x-2 mb-6">
                    <TabButton name="Parcel" isActive={activeTab === 'Parcel'} />
                    <TabButton name="LTL" isActive={activeTab === 'LTL'} />
                    <TabButton name="TruckLoad" isActive={activeTab === 'TruckLoad'} />
                </div>

                <form onSubmit={handleSubmit} className="space-y-6">
                    {activeTab === 'Parcel' && (
                        <>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label className="block mb-2 font-medium text-gray-700">Origin:</label>
                                    <input 
                                        type="text" 
                                        value={data.loadOrigin}
                                        onChange={e => setData('loadOrigin', e.target.value)}
                                        className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Enter pickup location"
                                    />
                                </div>
                                <div>
                                    <label className="block mb-2 font-medium text-gray-700">Destination:</label>
                                    <input 
                                        type="text" 
                                        value={data.deliverDestination}
                                        onChange={e => setData('deliverDestination', e.target.value)}
                                        className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Enter delivery location"
                                    />
                                </div>
                            </div>
                            <div>
                                <label className="block mb-2 font-medium text-gray-700">Pickup Date:</label>
                                <input 
                                    type="date" 
                                    value={data.pickupDate}
                                    onChange={e => setData('pickupDate', e.target.value)}
                                    className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                            <div>
                                <label className="block mb-2 font-medium text-gray-700">Items:</label>
                                {data.items.map((item, index) => (
                                    <div key={index} className="mb-4 p-4 border border-gray-300 rounded-md shadow-lg transition-shadow duration-300 hover:shadow-xl">
                                        <div className="grid grid-cols-1 gap-4">
                                            <label className="block">
                                                <span className="text-gray-700">Item Description:</span>
                                                <textarea
                                                    value={item.description}
                                                    onChange={(e) => updateItem(index, 'description', e.target.value)}
                                                    placeholder="Item description"
                                                    className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    rows="3"
                                                />
                                            </label>
                                            <label className="block">
                                                <span className="text-gray-700">Packaging Type:</span>
                                                <select
                                                    value={item.packagingType}
                                                    onChange={(e) => updateItem(index, 'packagingType', e.target.value)}
                                                    className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                >
                                                    <option value="">Select packaging type</option>
                                                    {packagingTypes.map((type) => (
                                                        <option key={type} value={type}>{type}</option>
                                                    ))}
                                                </select>
                                            </label>
                                            <div className="flex items-center">
                                                <span className="mr-4 text-gray-700">Is Stackable:</span>
                                                <label className="mr-4">
                                                    <input
                                                        type="radio"
                                                        checked={item.isStackable === 'yes'}
                                                        onChange={() => updateItem(index, 'isStackable', 'yes')}
                                                        className="mr-2"
                                                    />
                                                    Yes
                                                </label>
                                                <label>
                                                    <input
                                                        type="radio"
                                                        checked={item.isStackable === 'no'}
                                                        onChange={() => updateItem(index, 'isStackable', 'no')}
                                                        className="mr-2"
                                                    />
                                                    No
                                                </label>
                                            </div>
                                            <label className="block">
                                                <span className="text-gray-700">Quantity:</span>
                                                <input
                                                    type="number"
                                                    value={item.quantity}
                                                    onChange={(e) => updateItem(index, 'quantity', e.target.value)}
                                                    placeholder="Quantity"
                                                    className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                />
                                            </label>
                                            <label className="block">
                                                <span className="text-gray-700">Total Weight:</span>
                                                <input
                                                    type="number"
                                                    value={item.totalWeight}
                                                    onChange={(e) => updateItem(index, 'totalWeight', e.target.value)}
                                                    placeholder="Total weight"
                                                    className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                />
                                            </label>
                                            <div className="grid grid-cols-3 gap-4">
                                                <label className="block">
                                                    <span className="text-gray-700">Length (Inches):</span>
                                                    <input
                                                        type="number"
                                                        value={item.length}
                                                        onChange={(e) => updateItem(index, 'length', e.target.value)}
                                                        placeholder="Length"
                                                        className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    />
                                                </label>
                                                <label className="block">
                                                    <span className="text-gray-700">Width (Inches):</span>
                                                    <input
                                                        type="number"
                                                        value={item.width}
                                                        onChange={(e) => updateItem(index, 'width', e.target.value)}
                                                        placeholder="Width"
                                                        className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    />
                                                </label>
                                                <label className="block">
                                                    <span className="text-gray-700">Height (Inches):</span>
                                                    <input
                                                        type="number"
                                                        value={item.height}
                                                        onChange={(e) => updateItem(index, 'height', e.target.value)}
                                                        placeholder="Height"
                                                        className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                                <button
                                    type="button"
                                    onClick={addItem}
                                    className="flex items-center justify-center w-full p-2 mt-2 text-blue-500 border border-blue-500 rounded-md hover:bg-blue-50 transition-colors duration-200 shadow-md hover:shadow-lg"
                                >
                                    <FaPlus className="mr-2" />
                                    Add Item
                                </button>
                            </div>
                        </>
                    )}

                    <button 
                        type="submit" 
                        disabled={processing}
                        className="w-full bg-blue-500 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-600 transition-colors duration-200"
                    >
                        Get Quote
                    </button>
                </form>
            </div>
        </Layout>
    )
}

export default Index;
