import React, { useState } from 'react';
import { useForm } from '@inertiajs/inertia-react';
import Layout from '../Layout';
import { FaPlus, FaMapMarkerAlt, FaCalendarAlt, FaBoxOpen, FaWeightHanging, FaRuler, FaLayerGroup, FaExclamationTriangle, FaTrash } from 'react-icons/fa';

const Index = () => {
  const [activeTab, setActiveTab] = useState(0); // 0 for parcel, 1 for ltl and 2 for truckload

  const { data, setData, post, processing, errors } = useForm({
    origin: 'Kathmandu',
    form_type: 'parcel',
    destination: 'Kathmandu',
    pickup_date: '',
    instructions: 'Test',
    items: [{ description: 'Test', quantity: '1', weight: '1', length: '1', height: '1', width: '1', isStackable: false, isHazard: false }],
  });

  const { data: truckLoadData, setData: setTruckLoadData, post: postTruckLoad, processing: truckLoadProcessing, errors: truckLoadErrors } = useForm({
    origin: '',
    form_type: '',
    pickup_date: '',
    stops: [{
      destination: '',
      instructions: '',
      canDelete: false,
      items: [{
        description: '',
        quantity: '',
        weight: '',
        length: '',
        height: '',
        width: '',
        isStackable: false,
        isHazard: false,
        canDelete: false
      }]
    }]
  });

  const handleTabChange = (index, value, is_truckload) => {

    if (index == 0) {
      setData('form_type', 'parcel');
    } else if (index == 1) {
      setData('form_type', 'ltl');
    } else if (index == 2) {
      setTruckLoadData('form_type', 'truckload');
    }
    setActiveTab(index);
  };

  const handleAddItem = () => {
    setData('items', [...data.items, { description: '', quantity: '', weight: '', length: '', height: '', width: '', isStackable: false, isHazard: false, canDelete: true }]);
  };

  const handleDeleteItem = (index) => {
    if (data.items[index].canDelete) {
      const newItems = [...data.items];
      newItems.splice(index, 1);
      setData('items', newItems);
    }
  };

  const handleTruckLoadStopDelete = (index) => {
    if (truckLoadData.stops[index].canDelete) {
      const newStops = [...truckLoadData.stops];
      newStops.splice(index, 1);
      setTruckLoadData('stops', newStops);
    }
  };

  const handleItemChange = (index, event) => {
    const newItems = [...data.items];
    newItems[index][event.target.name] = event.target.value;
    setData('items', newItems);
  };

  const handleCheckboxChange = (index, event) => {
    const newItems = [...data.items];
    newItems[index][event.target.name] = event.target.checked;
    setData('items', newItems);
  };

  const clearParcelLtlForm = () => {
    setData({
      origin: '',
      form_type: 'parcel',
      destination: '',
      pickup_date: '',
      instructions: '',
      items: [{
        description: '',
        quantity: '',
        weight: '',
        length: '',
        height: '',
        width: '',
        isStackable: false,
        isHazard: false
      }],
    });
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log('submit', data);

    post('/shipper/quote'); // Update the endpoint as needed
    clearParcelLtlForm();
  };

  const handleTruckLoadSubmit = (e) => {
    e.preventDefault();
    postTruckLoad('/shipper/quote'); // Update the endpoint as needed
  };

  const handleAddStop = () => {
    setTruckLoadData('stops', [...truckLoadData.stops, {
      destination: '',
      instructions: '',
      canDelete: true,
      items: [{
        description: '',
        quantity: '',
        weight: '',
        length: '',
        height: '',
        width: '',
        isStackable: false,
        isHazard: false,
        canDelete: false
      }]
    }]);
  };

  const handleAddTruckLoadItem = (stopIndex) => {
    const newStops = [...truckLoadData.stops];
    newStops[stopIndex].items.push({
      description: '',
      quantity: '',
      weight: '',
      length: '',
      height: '',
      width: '',
      isStackable: false,
      isHazard: false,
      canDelete: true
    });
    setTruckLoadData('stops', newStops);
  };


  const handleTruckLoadChange = (stopIndex, itemIndex, event) => {
    const newStops = [...truckLoadData.stops];
    if (itemIndex === undefined) {
      newStops[stopIndex][event.target.name] = event.target.value;
    } else {
      newStops[stopIndex].items[itemIndex][event.target.name] = event.target.value;
    }
    setTruckLoadData('stops', newStops);
  };

  const validate2NumberAfterDecimalTruckLoad = (stopIndex, itemIndex, event) => {
    const value = parseFloat(event.target.value);
    if (isNaN(value) || !/^\d+(\.\d{1,2})?$/.test(event.target.value)) {
      event.target.value = '';
      handleTruckLoadChange(stopIndex, itemIndex, event);
    }
  }

  const handleTruckLoadCheckboxChange = (stopIndex, itemIndex, event) => {
    const newStops = [...truckLoadData.stops];
    newStops[stopIndex].items[itemIndex][event.target.name] = event.target.checked;
    setTruckLoadData('stops', newStops);
  };

  const handleDeleteTruckLoadItem = (stopIndex, itemIndex) => {
    if (truckLoadData.stops[stopIndex].items[itemIndex].canDelete) {
      const newStops = [...truckLoadData.stops];
      newStops[stopIndex].items.splice(itemIndex, 1);
      setTruckLoadData('stops', newStops);
    }
  };

  const validate2NumberAfterDecimal = (e, index) => {
    const value = parseFloat(e.target.value);
    if (isNaN(value) || !/^\d+(\.\d{1,2})?$/.test(e.target.value)) {
      e.target.value = '';
      handleItemChange(index, e);
    }
  };

  return (
    <Layout>
      <div className="p-4 mt-8 mb-8">
        <h4 className="text-3xl font-bold mb-6 text-center text-indigo-800">Get Quote For Your Shipment</h4>
        <div role="tablist" className="tabs tabs-lifted mb-6">
          <input type="radio"
            name="my_tabs_2" role="tab"
            className="tab"
            aria-label="Parcel"
            checked={activeTab === 0}
            onChange={() => handleTabChange(0, 'parcel', false)}
          />
          <div role="tabpanel" className="tab-content bg-base-100 border-base-300 rounded-box p-6">
            <div id="parcelContent" className="animate-fade-in">
              <form onSubmit={handleSubmit}>
                <div className="grid md:grid-cols-2 gap-4 mb-4">
                  <div className="form-control">
                    <label className="label">
                      <span className="label-text flex items-center"><FaMapMarkerAlt className="mr-2" /> Origin</span>
                    </label>
                    <input
                      type="text"
                      className={`input input-bordered w-full ${errors.origin ? 'input-error' : ''}`}
                      placeholder="Enter origin"
                      value={data.origin}
                      onChange={(e) => setData('origin', e.target.value)}
                    />
                    {errors.origin && <span className="text-error">{errors.origin}</span>}
                  </div>
                  <div className="form-control">
                    <label className="label">
                      <span className="label-text flex items-center"><FaMapMarkerAlt className="mr-2" /> Destination</span>
                    </label>
                    <input
                      type="text"
                      className={`input input-bordered w-full ${errors.destination ? 'input-error' : ''}`}
                      placeholder="Enter destination"
                      value={data.destination}
                      onChange={(e) => setData('destination', e.target.value)}
                    />
                    {errors.destination && <span className="text-error">{errors.destination}</span>}
                  </div>
                </div>
                <div className="mb-4">
                  <label className="label">
                    <span className="label-text flex items-center"><FaCalendarAlt className="mr-2" /> Pickup Date</span>
                  </label>
                  <input
                    type="date"
                    className={`input input-bordered w-full ${errors.pickup_date ? 'input-error' : ''}`}
                    value={data.pickup_date}
                    onChange={(e) => setData('pickup_date', e.target.value)}
                  />
                  {errors.pickup_date && <span className="text-error">{errors.pickup_date}</span>}
                </div>
                <div className="mb-6">
                  <label className="label">
                    <span className="label-text">Instructions</span>
                  </label>
                  <textarea
                    className="textarea textarea-bordered w-full"
                    placeholder="Additional instructions"
                    value={data.instructions}
                    onChange={(e) => setData('instructions', e.target.value)}
                  ></textarea>
                </div>
                <div className="flex justify-between items-center mb-4">
                  <h3 className="text-2xl font-semibold text-indigo-700">Parcel Items</h3>
                  <button onClick={handleAddItem} type="button" className="btn btn-primary btn-sm px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <FaPlus className="mr-1 text-xs" /> Add Item
                  </button>
                </div>
                {data.items.map((item, index) => (
                  <div key={index} className="mb-6 border border-indigo-200 p-6 rounded-lg bg-white shadow-md">
                    <div className="mb-4">
                      <label className="label">
                        <span className="label-text flex items-center"><FaBoxOpen className="mr-2" /> Item Description</span>
                      </label>
                      <input
                        type="text"
                        className={`input input-bordered w-full ${errors[`items.${index}.description`] ? 'input-error' : ''}`}
                        name="description"
                        value={item.description}
                        onChange={(e) => handleItemChange(index, e)}
                        placeholder="Describe the item"
                      />
                      {errors[`items.${index}.description`] && <span className="text-error">{errors[`items.${index}.description`]}</span>}
                    </div>
                    <div className="grid md:grid-cols-2 gap-4 mb-4">
                      <div className="form-control">
                        <label className="label">
                          <span className="label-text flex items-center"><FaBoxOpen className="mr-2" /> Quantity</span>
                        </label>
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.quantity`] ? 'input-error' : ''}`}
                          name="quantity"
                          value={item.quantity}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Enter quantity"
                        />
                        {errors[`items.${index}.quantity`] && <span className="text-error">{errors[`items.${index}.quantity`]}</span>}
                      </div>
                      <div className="form-control">
                        <label className="label">
                          <span className="label-text flex items-center"><FaWeightHanging className="mr-2" /> Weight (kg)</span>
                        </label>
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.weight`] ? 'input-error' : ''}`}
                          name="weight"
                          value={item.weight}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Enter weight"
                          step="0.01" // Allows increments of 0.01
                          onBlur={(e) => validate2NumberAfterDecimal(e, index)}
                        />
                        {errors[`items.${index}.weight`] && <span className="text-error">{errors[`items.${index}.weight`]}</span>}
                      </div>
                    </div>
                    <div className="mb-4">
                      <label className="label">
                        <span className="label-text flex items-center"><FaRuler className="mr-2" /> Dimensions (L x H x W in cm)</span>
                      </label>
                      <div className="flex space-x-2">
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.length`] ? 'input-error' : ''}`}
                          name="length"
                          value={item.length}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Length"
                          step="0.01" // Allows increments of 0.01
                          onBlur={(e) => validate2NumberAfterDecimal(e, index)}
                        />
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.height`] ? 'input-error' : ''}`}
                          name="height"
                          value={item.height}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Height"
                          step="0.01" // Allows increments of 0.01
                          onBlur={(e) => validate2NumberAfterDecimal(e, index)}
                        />
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.width`] ? 'input-error' : ''}`}
                          name="width"
                          value={item.width}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Width"
                          step="0.01" // Allows increments of 0.01
                          onBlur={(e) => validate2NumberAfterDecimal(e, index)}
                        />
                      </div>
                      {(errors[`items.${index}.length`] || errors[`items.${index}.height`] || errors[`items.${index}.width`]) &&
                        <span className="text-error">Please provide valid dimensions</span>}
                    </div>
                    <div className="flex flex-wrap gap-4">
                      <label className="label cursor-pointer">
                        <input
                          type="checkbox"
                          className="checkbox checkbox-primary mr-2"
                          name="isStackable"
                          checked={item.isStackable}
                          onChange={(e) => handleCheckboxChange(index, e)}
                        />
                        <span className="label-text flex items-center"><FaLayerGroup className="mr-2" /> Is Stackable</span>
                      </label>
                      <label className="label cursor-pointer">
                        <input
                          type="checkbox"
                          className="checkbox checkbox-secondary mr-2"
                          name="isHazard"
                          checked={item.isHazard}
                          onChange={(e) => handleCheckboxChange(index, e)}
                        />
                        <span className="label-text flex items-center"><FaExclamationTriangle className="mr-2" /> Is Hazard Material</span>
                      </label>
                    </div>
                    {item.canDelete && (
                      <button
                        type="button"
                        onClick={() => handleDeleteItem(index)}
                        className="btn btn-error btn-sm mt-2"
                      >
                        <FaTrash className="mr-1" /> Delete Item
                      </button>
                    )}
                  </div>
                ))}

                <button type="submit" className="btn btn-success w-full mt-4" disabled={processing}>
                  {processing ? 'Processing...' : 'Submit'}
                </button>
              </form>
            </div>
          </div>

          <input type="radio"
            name="my_tabs_2"
            role="tab"
            className="tab"
            aria-label="LTL"
            checked={activeTab === 1}
            onChange={() => handleTabChange(1, 'ltl', true)}
          />
          <div role="tabpanel" className="tab-content bg-base-100 border-base-300 rounded-box p-6">
            <div id="ltlContent" className="animate-fade-in">
              <form onSubmit={handleSubmit}>
                <div className="grid md:grid-cols-2 gap-4 mb-4">
                  <div className="form-control">
                    <label className="label">
                      <span className="label-text flex items-center"><FaMapMarkerAlt className="mr-2" /> Origin</span>
                    </label>
                    <input
                      type="text"
                      className={`input input-bordered w-full ${errors.origin ? 'input-error' : ''}`}
                      placeholder="Enter origin"
                      value={data.origin}
                      onChange={(e) => setData('origin', e.target.value)}
                    />
                    {errors.origin && <span className="text-error">{errors.origin}</span>}
                  </div>
                  <div className="form-control">
                    <label className="label">
                      <span className="label-text flex items-center"><FaMapMarkerAlt className="mr-2" /> Destination</span>
                    </label>
                    <input
                      type="text"
                      className={`input input-bordered w-full ${errors.destination ? 'input-error' : ''}`}
                      placeholder="Enter destination"
                      value={data.destination}
                      onChange={(e) => setData('destination', e.target.value)}
                    />
                    {errors.destination && <span className="text-error">{errors.destination}</span>}
                  </div>
                </div>
                <div className="mb-4">
                  <label className="label">
                    <span className="label-text flex items-center"><FaCalendarAlt className="mr-2" /> Pickup Date</span>
                  </label>
                  <input
                    type="date"
                    className={`input input-bordered w-full ${errors.pickup_date ? 'input-error' : ''}`}
                    value={data.pickup_date}
                    onChange={(e) => setData('pickup_date', e.target.value)}
                  />
                  {errors.pickup_date && <span className="text-error">{errors.pickup_date}</span>}
                </div>
                <div className="mb-6">
                  <label className="label">
                    <span className="label-text">Instructions</span>
                  </label>
                  <textarea
                    className="textarea textarea-bordered w-full"
                    placeholder="Additional instructions"
                    value={data.instructions}
                    onChange={(e) => setData('instructions', e.target.value)}
                  ></textarea>
                </div>
                <div className="flex justify-between items-center mb-4">
                  <h3 className="text-2xl font-semibold text-indigo-700">LTL Items</h3>
                  <button onClick={handleAddItem} type="button" className="btn btn-primary btn-sm px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <FaPlus className="mr-1 text-xs" /> Add Item
                  </button>
                </div>
                {data.items.map((item, index) => (
                  <div key={index} className="mb-6 border border-indigo-200 p-6 rounded-lg bg-white shadow-md">
                    <div className="mb-4">
                      <label className="label">
                        <span className="label-text flex items-center"><FaBoxOpen className="mr-2" /> Item Description</span>
                      </label>
                      <input
                        type="text"
                        className={`input input-bordered w-full ${errors[`items.${index}.description`] ? 'input-error' : ''}`}
                        name="description"
                        value={item.description}
                        onChange={(e) => handleItemChange(index, e)}
                        placeholder="Describe the item"
                      />
                      {errors[`items.${index}.description`] && <span className="text-error">{errors[`items.${index}.description`]}</span>}
                    </div>
                    <div className="grid md:grid-cols-2 gap-4 mb-4">
                      <div className="form-control">
                        <label className="label">
                          <span className="label-text flex items-center"><FaBoxOpen className="mr-2" /> Quantity</span>
                        </label>
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.quantity`] ? 'input-error' : ''}`}
                          name="quantity"
                          value={item.quantity}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Enter quantity"
                        />
                        {errors[`items.${index}.quantity`] && <span className="text-error">{errors[`items.${index}.quantity`]}</span>}
                      </div>
                      <div className="form-control">
                        <label className="label">
                          <span className="label-text flex items-center"><FaWeightHanging className="mr-2" /> Weight (kg)</span>
                        </label>
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.weight`] ? 'input-error' : ''}`}
                          name="weight"
                          value={item.weight}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Enter weight"
                          step="0.01" // Allows increments of 0.01
                          onBlur={(e) => validate2NumberAfterDecimal(e, index)}
                        />
                        {errors[`items.${index}.weight`] && <span className="text-error">{errors[`items.${index}.weight`]}</span>}
                      </div>
                    </div>
                    <div className="mb-4">
                      <label className="label">
                        <span className="label-text flex items-center"><FaRuler className="mr-2" /> Dimensions (L x H x W in cm)</span>
                      </label>
                      <div className="flex space-x-2">
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.length`] ? 'input-error' : ''}`}
                          name="length"
                          value={item.length}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Length"
                          step="0.01" // Allows increments of 0.01
                          onBlur={(e) => validate2NumberAfterDecimal(e, index)}
                        />
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.height`] ? 'input-error' : ''}`}
                          name="height"
                          value={item.height}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Height"
                          step="0.01" // Allows increments of 0.01
                          onBlur={(e) => validate2NumberAfterDecimal(e, index)}
                        />
                        <input
                          type="number"
                          className={`input input-bordered w-full ${errors[`items.${index}.width`] ? 'input-error' : ''}`}
                          name="width"
                          value={item.width}
                          onChange={(e) => handleItemChange(index, e)}
                          placeholder="Width"
                          step="0.01" // Allows increments of 0.01
                          onBlur={(e) => validate2NumberAfterDecimal(e, index)}
                        />
                      </div>
                      {(errors[`items.${index}.length`] || errors[`items.${index}.height`] || errors[`items.${index}.width`]) &&
                        <span className="text-error">Please provide valid dimensions</span>}
                    </div>
                    <div className="flex flex-wrap gap-4">
                      <label className="label cursor-pointer">
                        <input
                          type="checkbox"
                          className="checkbox checkbox-primary mr-2"
                          name="isStackable"
                          checked={item.isStackable}
                          onChange={(e) => handleCheckboxChange(index, e)}
                        />
                        <span className="label-text flex items-center"><FaLayerGroup className="mr-2" /> Is Stackable</span>
                      </label>
                      <label className="label cursor-pointer">
                        <input
                          type="checkbox"
                          className="checkbox checkbox-secondary mr-2"
                          name="isHazard"
                          checked={item.isHazard}
                          onChange={(e) => handleCheckboxChange(index, e)}
                        />
                        <span className="label-text flex items-center"><FaExclamationTriangle className="mr-2" /> Is Hazard Material</span>
                      </label>
                    </div>
                    {item.canDelete && (
                      <button
                        type="button"
                        onClick={() => handleDeleteItem(index)}
                        className="btn btn-error btn-sm mt-2"
                      >
                        <FaTrash className="mr-1" /> Delete Item
                      </button>
                    )}
                  </div>
                ))}

                <button type="submit" className="btn btn-success w-full mt-4" disabled={processing}>
                  {processing ? 'Processing...' : 'Submit'}
                </button>
              </form>
            </div>
          </div>

          <input type="radio"
            name="my_tabs_2"
            role="tab"
            className="tab"
            aria-label="TruckLoad"
            checked={activeTab === 2}
            onChange={() => handleTabChange(2, 'truckload', true)}
          />
          <div role="tabpanel" className="tab-content bg-base-100 border-base-300 rounded-box p-6">
            <div id="truckloadContent" className="animate-fade-in">
              <form onSubmit={handleTruckLoadSubmit}>
                <div className="mb-4">
                  <label className="label">
                    <span className="label-text flex items-center"><FaMapMarkerAlt className="mr-2" /> Origin</span>
                  </label>
                  <input
                    type="text"
                    className={`input input-bordered w-full ${truckLoadErrors.origin ? 'input-error' : ''}`}
                    name="origin"
                    value={truckLoadData.origin}
                    onChange={(e) => setTruckLoadData('origin', e.target.value)}
                    placeholder="Enter origin"
                  />
                  {truckLoadErrors.origin && <span className="text-error">{truckLoadErrors.origin}</span>}
                </div>
                <div className="mb-4">
                  <label className="label">
                    <span className="label-text flex items-center"><FaCalendarAlt className="mr-2" /> Pickup Date</span>
                  </label>
                  <input
                    type="date"
                    className={`input input-bordered w-full ${truckLoadErrors.pickup_date ? 'input-error' : ''}`}
                    name="pickup_date"
                    value={truckLoadData.pickup_date}
                    onChange={(e) => setTruckLoadData('pickup_date', e.target.value)}
                  />
                  {truckLoadErrors.pickup_date && <span className="text-error">{truckLoadErrors.pickup_date}</span>}
                </div>
                <div className="flex justify-between items-center mb-4">
                  <h3 className="text-2xl font-semibold text-indigo-700">Stops</h3>
                  <button onClick={handleAddStop} type="button" className="btn btn-primary btn-sm px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 ease-in-out hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <FaPlus className="mr-1 text-xs" /> Add Stop
                  </button>
                </div>
                {truckLoadData.stops.map((stop, stopIndex) => (
                  <div key={stopIndex} className="mb-6 border border-indigo-200 p-6 rounded-lg bg-white shadow-md">
                    <h3 className="text-xl font-semibold mb-4">Stop {stopIndex + 1}</h3>
                    <div className="mb-4">
                      <label className="label">
                        <span className="label-text flex items-center"><FaMapMarkerAlt className="mr-2" /> Destination</span>
                      </label>
                      <input
                        type="text"
                        className={`input input-bordered w-full ${truckLoadErrors[`stops.${stopIndex}.destination`] ? 'input-error' : ''}`}
                        name="destination"
                        value={stop.destination}
                        onChange={(e) => handleTruckLoadChange(stopIndex, undefined, e)}
                        placeholder="Enter destination"
                      />
                      {truckLoadErrors[`stops.${stopIndex}.destination`] && <span className="text-error">{truckLoadErrors[`stops.${stopIndex}.destination`]}</span>}
                    </div>
                    <div className="mb-4">
                      <label className="label">
                        <span className="label-text">Instructions</span>
                      </label>
                      <textarea
                        className="textarea textarea-bordered w-full"
                        name="instructions"
                        value={stop.instructions}
                        onChange={(e) => handleTruckLoadChange(stopIndex, undefined, e)}
                        placeholder="Additional instructions"
                      ></textarea>
                    </div>
                    <div className="flex justify-between items-center mb-4">
                      <h4 className="text-lg font-semibold">Items</h4>
                      <button onClick={() => handleAddTruckLoadItem(stopIndex)} type="button" className="btn btn-primary btn-sm">
                        <FaPlus className="mr-1" /> Add Item
                      </button>
                    </div>
                    {stop.items.map((item, itemIndex) => (
                      <div key={itemIndex} className="mb-4 border-t pt-4">
                        <div className="mb-2">
                          <label className="label">
                            <span className="label-text">Description</span>
                          </label>
                          <input
                            type="text"
                            className="input input-bordered w-full"
                            name="description"
                            value={item.description}
                            onChange={(e) => handleTruckLoadChange(stopIndex, itemIndex, e)}
                            placeholder="Item description"
                          />
                        </div>
                        <div className="grid grid-cols-2 gap-2">
                          <div>
                            <label className="label">
                              <span className="label-text">Quantity</span>
                            </label>
                            <input
                              type="number"
                              className="input input-bordered w-full"
                              name="quantity"
                              value={item.quantity}
                              onChange={(e) => handleTruckLoadChange(stopIndex, itemIndex, e)}
                              placeholder="Quantity"
                            />
                          </div>
                          <div>
                            <label className="label">
                              <span className="label-text">Weight (kg)</span>
                            </label>
                            <input
                              type="number"
                              className="input input-bordered w-full"
                              name="weight"
                              value={item.weight}
                              onChange={(e) => handleTruckLoadChange(stopIndex, itemIndex, e)}
                              placeholder="Weight"
                              step="0.01" // Allows increments of 0.01
                              onBlur={(e) => validate2NumberAfterDecimalTruckLoad(stopIndex, itemIndex, e)}
                            />
                          </div>
                        </div>
                        <div className="grid grid-cols-3 gap-2 mt-2">
                          <div>
                            <label className="label">
                              <span className="label-text">Length (cm)</span>
                            </label>
                            <input
                              type="number"
                              className="input input-bordered w-full"
                              name="length"
                              value={item.length}
                              onChange={(e) => handleTruckLoadChange(stopIndex, itemIndex, e)}
                              placeholder="Length"
                              step="0.01" // Allows increments of 0.01
                              onBlur={(e) => validate2NumberAfterDecimalTruckLoad(stopIndex, itemIndex, e)}
                            />
                          </div>
                          <div>
                            <label className="label">
                              <span className="label-text">Height (cm)</span>
                            </label>
                            <input
                              type="number"
                              className="input input-bordered w-full"
                              name="height"
                              value={item.height}
                              onChange={(e) => handleTruckLoadChange(stopIndex, itemIndex, e)}
                              placeholder="Height"
                              step="0.01" // Allows increments of 0.01
                              onBlur={(e) => validate2NumberAfterDecimalTruckLoad(stopIndex, itemIndex, e)}
                            />
                          </div>
                          <div>
                            <label className="label">
                              <span className="label-text">Width (cm)</span>
                            </label>
                            <input
                              type="number"
                              className="input input-bordered w-full"
                              name="width"
                              value={item.width}
                              onChange={(e) => handleTruckLoadChange(stopIndex, itemIndex, e)}
                              placeholder="Width"
                              step="0.01" // Allows increments of 0.01
                              onBlur={(e) => validate2NumberAfterDecimalTruckLoad(stopIndex, itemIndex, e)}
                            />
                          </div>
                        </div>
                        <div className="flex flex-wrap gap-2">
                          <label className="label cursor-pointer">
                            <input
                              type="checkbox"
                              className="checkbox checkbox-primary mr-2"
                              name="isStackable"
                              checked={item.isStackable}
                              onChange={(e) => handleTruckLoadCheckboxChange(stopIndex, itemIndex, e)}
                            />
                            <span className="label-text flex items-center">Is Stackable</span>
                          </label>
                          <label className="label cursor-pointer">
                            <input
                              type="checkbox"
                              className="checkbox checkbox-secondary mr-2"
                              name="isHazard"
                              checked={item.isHazard}
                              onChange={(e) => handleTruckLoadCheckboxChange(stopIndex, itemIndex, e)}
                            />
                            <span className="label-text flex items-center">Is Hazard Material</span>
                          </label>
                        </div>
                        {item.canDelete && (
                          <button
                            type="button"
                            onClick={() => handleDeleteTruckLoadItem(stopIndex, itemIndex)}
                            className="btn btn-error btn-sm mt-2"
                          >
                            <FaTrash className="mr-1" /> Delete Item
                          </button>
                        )}
                      </div>
                    ))}
                    {stop.canDelete && (
                      <button
                        type="button"
                        onClick={() => handleTruckLoadStopDelete(stopIndex)}
                        className="btn btn-error btn-sm mt-4"
                      >
                        <FaTrash className="mr-1" /> Delete Stop
                      </button>
                    )}
                  </div>
                ))}
                <button type="submit" className="btn btn-success w-full mt-4" disabled={truckLoadProcessing}>
                  {truckLoadProcessing ? 'Processing...' : 'Submit'}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default Index;
