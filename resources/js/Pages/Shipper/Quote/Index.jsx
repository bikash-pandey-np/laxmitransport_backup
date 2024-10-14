import React, { useState, useEffect } from 'react'
import { useForm } from '@inertiajs/inertia-react'
import Layout from '../Layout';
import { FaPlus, FaTrash } from 'react-icons/fa';

const Index = ({title}) => {
    const [activeTab, setActiveTab] = useState('Parcel');
    const { data, setData, post, processing, errors, setError, clearErrors } = useForm({
        loadType: 'Parcel',
        loadOrigin: '',
        pickupDate: '',
        deliverDestination: '',
        items: [{
            description: '',
            packagingType: '',
            isStackable: 'no',
            quantity: '',
            totalWeight: '',
            length: '',
            width: '',
            height: ''
        }],
        truckType: '',
        deliveryDate: '',
        stops: [{
            address: '',
            items: [{
                description: '',
                quantity: '',
                totalWeight: '',
                length: '',
                width: '',
                height: '',
                packagingType: '',
                isStackable: 'no'
            }]
        }],
        specialDeliveryInstruction: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log('clicked');
        clearErrors();
        let hasErrors = false;

        // Check for empty fields
        Object.keys(data).forEach(key => {
            if (data[key] === '' || (Array.isArray(data[key]) && data[key].length === 0)) {
                setError(key, 'This field is required.');
                hasErrors = true;
            }
        });

        if (data.loadType === 'Parcel' || data.loadType === 'LTL') {
            if (data.items.length === 0) {
                setError('items', 'At least one item is required for Parcel and LTL shipments.');
                hasErrors = true;
            } else {
                data.items.forEach((item, index) => {
                    Object.keys(item).forEach(key => {
                        if (item[key] === '') {
                            setError(`items.${index}.${key}`, 'This field is required.');
                            hasErrors = true;
                        }
                    });
                });
            }
        } else if (data.loadType === 'TruckLoad') {
            if (data.stops.length === 0) {
                setError('stops', 'At least one stop is required for TruckLoad shipments.');
                hasErrors = true;
            } else {
                data.stops.forEach((stop, stopIndex) => {
                    if (stop.address === '') {
                        setError(`stops.${stopIndex}.address`, 'Address is required.');
                        hasErrors = true;
                    }
                    stop.items.forEach((item, itemIndex) => {
                        Object.keys(item).forEach(key => {
                            if (item[key] === '') {
                                setError(`stops.${stopIndex}.items.${itemIndex}.${key}`, 'This field is required.');
                                hasErrors = true;
                            }
                        });
                    });
                });
            }
        }

        if (!hasErrors) {
            console.log(data);
            post('/shipper/quote');
        }
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

    const addStop = () => {
        setData('stops', [...data.stops, {
            address: '',
            items: []
        }]);
    };

    const updateStop = (index, field, value) => {
        const updatedStops = [...data.stops];
        updatedStops[index][field] = value;
        setData('stops', updatedStops);
    };

    const addItemToStop = (stopIndex) => {
        const updatedStops = [...data.stops];
        updatedStops[stopIndex].items.push({
            description: '',
            quantity: '',
            totalWeight: '',
            length: '',
            width: '',
            height: '',
            packagingType: '',
            isStackable: 'no'
        });
        setData('stops', updatedStops);
    };

    const updateItemInStop = (stopIndex, itemIndex, field, value) => {
        const updatedStops = [...data.stops];
        updatedStops[stopIndex].items[itemIndex][field] = value;
        setData('stops', updatedStops);
    };

    const removeStop = (index) => {
        const updatedStops = [...data.stops];
        updatedStops.splice(index, 1);
        setData('stops', updatedStops);
    };

    const packagingTypes = ['Box', 'Pallet', 'Crate', 'Drum', 'Other'];
    const truckTypes = ['Dry Van', 'Refrigerated', 'Flatbed', 'Step Deck', 'Lowboy', 'RGN'];

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
                    {(activeTab === 'Parcel' || activeTab === 'LTL') && (
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
                                    {errors.loadOrigin && <div className="text-red-500 text-sm mt-1">{errors.loadOrigin}</div>}
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
                                    {errors.deliverDestination && <div className="text-red-500 text-sm mt-1">{errors.deliverDestination}</div>}
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
                                {errors.pickupDate && <div className="text-red-500 text-sm mt-1">{errors.pickupDate}</div>}
                            </div>
                            <div>
                                <label className="block mb-2 font-medium text-gray-700">Special Delivery Instruction:</label>
                                <textarea 
                                    value={data.specialDeliveryInstruction}
                                    onChange={e => setData('specialDeliveryInstruction', e.target.value)}
                                    className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    rows="3"
                                    placeholder="Enter any special delivery instructions"
                                />
                                {errors.specialDeliveryInstruction && <div className="text-red-500 text-sm mt-1">{errors.specialDeliveryInstruction}</div>}
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

                    {activeTab === 'TruckLoad' && (
                        <>
                            <div>
                                <label className="block mb-2 font-medium text-gray-700">Truck Type:</label>
                                <select
                                    value={data.truckType}
                                    onChange={(e) => setData('truckType', e.target.value)}
                                    className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="">Select truck type</option>
                                    {truckTypes.map((type) => (
                                        <option key={type} value={type}>{type}</option>
                                    ))}
                                </select>
                                {errors.truckType && <div className="text-red-500 text-sm mt-1">{errors.truckType}</div>}
                            </div>
                            <div>
                                <label className="block mb-2 font-medium text-gray-700">Delivery Date:</label>
                                <input 
                                    type="date" 
                                    value={data.deliveryDate}
                                    onChange={e => setData('deliveryDate', e.target.value)}
                                    className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                                {errors.deliveryDate && <div className="text-red-500 text-sm mt-1">{errors.deliveryDate}</div>}
                            </div>
                            <div>
                                <label className="block mb-2 font-medium text-gray-700">Special Delivery Instruction:</label>
                                <textarea 
                                    value={data.specialDeliveryInstruction}
                                    onChange={e => setData('specialDeliveryInstruction', e.target.value)}
                                    className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    rows="3"
                                    placeholder="Enter any special delivery instructions"
                                />
                                {errors.specialDeliveryInstruction && <div className="text-red-500 text-sm mt-1">{errors.specialDeliveryInstruction}</div>}
                            </div>
                            <div>
                                <label className="block mb-2 font-medium text-gray-700">Stops:</label>
                                {data.stops.map((stop, stopIndex) => (
                                    <div key={stopIndex} className="mb-4 p-4 border border-gray-300 rounded-md shadow-lg transition-shadow duration-300 hover:shadow-xl">
                                        <div className="flex justify-between items-center mb-2">
                                            <h3 className="text-lg font-semibold">Stop {stopIndex + 1}</h3>
                                            <button
                                                type="button"
                                                onClick={() => removeStop(stopIndex)}
                                                className="text-red-500 hover:text-red-700"
                                            >
                                                <FaTrash />
                                            </button>
                                        </div>
                                        <label className="block mb-2">
                                            <span className="text-gray-700">Address:</span>
                                            <input
                                                type="text"
                                                value={stop.address}
                                                onChange={(e) => updateStop(stopIndex, 'address', e.target.value)}
                                                placeholder="Enter address"
                                                className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            />
                                            {errors[`stops.${stopIndex}.address`] && <div className="text-red-500 text-sm mt-1">{errors[`stops.${stopIndex}.address`]}</div>}
                                        </label>
                                        <div>
                                            <h4 className="font-medium mb-2">Items:</h4>
                                            {stop.items.map((item, itemIndex) => (
                                                <div key={itemIndex} className="mb-2 p-2 border border-gray-200 rounded">
                                                    <label className="block mb-1">
                                                        <span className="text-gray-700">Description:</span>
                                                        <input
                                                            type="text"
                                                            value={item.description}
                                                            onChange={(e) => updateItemInStop(stopIndex, itemIndex, 'description', e.target.value)}
                                                            placeholder="Item description"
                                                            className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                        />
                                                        {errors[`stops.${stopIndex}.items.${itemIndex}.description`] && <div className="text-red-500 text-sm mt-1">{errors[`stops.${stopIndex}.items.${itemIndex}.description`]}</div>}
                                                    </label>
                                                    <label className="block mb-1">
                                                        <span className="text-gray-700">Quantity:</span>
                                                        <input
                                                            type="number"
                                                            value={item.quantity}
                                                            onChange={(e) => updateItemInStop(stopIndex, itemIndex, 'quantity', e.target.value)}
                                                            placeholder="Quantity"
                                                            className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                        />
                                                        {errors[`stops.${stopIndex}.items.${itemIndex}.quantity`] && <div className="text-red-500 text-sm mt-1">{errors[`stops.${stopIndex}.items.${itemIndex}.quantity`]}</div>}
                                                    </label>
                                                    <label className="block mb-1">
                                                        <span className="text-gray-700">Total Weight:</span>
                                                        <input
                                                            type="number"
                                                            value={item.totalWeight}
                                                            onChange={(e) => updateItemInStop(stopIndex, itemIndex, 'totalWeight', e.target.value)}
                                                            placeholder="Total weight"
                                                            className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                        />
                                                        {errors[`stops.${stopIndex}.items.${itemIndex}.totalWeight`] && <div className="text-red-500 text-sm mt-1">{errors[`stops.${stopIndex}.items.${itemIndex}.totalWeight`]}</div>}
                                                    </label>
                                                    <div className="grid grid-cols-3 gap-4 mb-1">
                                                        <label className="block">
                                                            <span className="text-gray-700">Length (Inches):</span>
                                                            <input
                                                                type="number"
                                                                value={item.length}
                                                                onChange={(e) => updateItemInStop(stopIndex, itemIndex, 'length', e.target.value)}
                                                                placeholder="Length"
                                                                className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                            />
                                                            {errors[`stops.${stopIndex}.items.${itemIndex}.length`] && <div className="text-red-500 text-sm mt-1">{errors[`stops.${stopIndex}.items.${itemIndex}.length`]}</div>}
                                                        </label>
                                                        <label className="block">
                                                            <span className="text-gray-700">Width (Inches):</span>
                                                            <input
                                                                type="number"
                                                                value={item.width}
                                                                onChange={(e) => updateItemInStop(stopIndex, itemIndex, 'width', e.target.value)}
                                                                placeholder="Width"
                                                                className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                            />
                                                            {errors[`stops.${stopIndex}.items.${itemIndex}.width`] && <div className="text-red-500 text-sm mt-1">{errors[`stops.${stopIndex}.items.${itemIndex}.width`]}</div>}
                                                        </label>
                                                        <label className="block">
                                                            <span className="text-gray-700">Height (Inches):</span>
                                                            <input
                                                                type="number"
                                                                value={item.height}
                                                                onChange={(e) => updateItemInStop(stopIndex, itemIndex, 'height', e.target.value)}
                                                                placeholder="Height"
                                                                className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                            />
                                                            {errors[`stops.${stopIndex}.items.${itemIndex}.height`] && <div className="text-red-500 text-sm mt-1">{errors[`stops.${stopIndex}.items.${itemIndex}.height`]}</div>}
                                                        </label>
                                                    </div>
                                                    <label className="block mb-1">
                                                        <span className="text-gray-700">Packaging Type:</span>
                                                        <select
                                                            value={item.packagingType}
                                                            onChange={(e) => updateItemInStop(stopIndex, itemIndex, 'packagingType', e.target.value)}
                                                            className="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                        >
                                                            <option value="">Select packaging type</option>
                                                            {packagingTypes.map((type) => (
                                                                <option key={type} value={type}>{type}</option>
                                                            ))}
                                                        </select>
                                                        {errors[`stops.${stopIndex}.items.${itemIndex}.packagingType`] && <div className="text-red-500 text-sm mt-1">{errors[`stops.${stopIndex}.items.${itemIndex}.packagingType`]}</div>}
                                                    </label>
                                                    <div className="flex items-center mb-1">
                                                        <span className="mr-4 text-gray-700">Is Stackable:</span>
                                                        <label className="mr-4">
                                                            <input
                                                                type="radio"
                                                                checked={item.isStackable === 'yes'}
                                                                onChange={() => updateItemInStop(stopIndex, itemIndex, 'isStackable', 'yes')}
                                                                className="mr-2"
                                                            />
                                                            Yes
                                                        </label>
                                                        <label>
                                                            <input
                                                                type="radio"
                                                                checked={item.isStackable === 'no'}
                                                                onChange={() => updateItemInStop(stopIndex, itemIndex, 'isStackable', 'no')}
                                                                className="mr-2"
                                                            />
                                                            No
                                                        </label>
                                                        {errors[`stops.${stopIndex}.items.${itemIndex}.isStackable`] && <div className="text-red-500 text-sm mt-1">{errors[`stops.${stopIndex}.items.${itemIndex}.isStackable`]}</div>}
                                                    </div>
                                                </div>
                                            ))}
                                            <button
                                                type="button"
                                                onClick={() => addItemToStop(stopIndex)}
                                                className="mt-2 p-2 text-blue-500 border border-blue-500 rounded-md hover:bg-blue-50 transition-colors duration-200"
                                            >
                                                <FaPlus className="inline mr-2" />
                                                Add Item
                                            </button>
                                        </div>
                                    </div>
                                ))}
                                <button
                                    type="button"
                                    onClick={addStop}
                                    className="flex items-center justify-center w-full p-2 mt-2 text-blue-500 border border-blue-500 rounded-md hover:bg-blue-50 transition-colors duration-200 shadow-md hover:shadow-lg"
                                >
                                    <FaPlus className="mr-2" />
                                    Add Stop
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
