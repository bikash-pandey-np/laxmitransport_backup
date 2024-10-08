import React from 'react';

const Select = ({ options, value, onChange, placeholder = "Select an option", className }) => {
  return (
    <div className={`relative inline-block w-full ${className}`}>
      <select
        value={value}
        onChange={onChange}
        className="block appearance-none w-full bg-white border border-gray-300 rounded-md py-2 pl-3 pr-10 text-gray-700 focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
      >
        <option value="" disabled>{placeholder}</option>
        {options.map((option) => (
          <option key={option.id} value={option.id}>
            {option.name}
          </option>
        ))}
      </select>
      <div className="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
        <svg
          className="w-5 h-5 text-gray-400"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M7 10l5 5 5-5H7z" />
        </svg>
      </div>
    </div>
  );
};

export default Select;
