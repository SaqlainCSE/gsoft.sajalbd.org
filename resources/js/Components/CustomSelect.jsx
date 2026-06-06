import React from 'react';
import { Controller, useForm } from 'react-hook-form';
import Select from 'react-select';

const CustomSelect = ({control, name, onChange, onInputChange,options, style, value, isClearable = true, isLoading = false, isRequired = false }) => {

    return (
        <Controller
            name={name}
            control={control}
            rules={{
                required: isRequired
                            ? "This is required"
                            : false,
            }}
            render={() => (
                <>
                    <Select 
                        styles={{
                            control: (baseStyles, state) => ({
                                ...baseStyles,
                                ...style
                            }),
                        }}
                        onInputChange={onInputChange}
                        className="basic-single"
                        classNamePrefix="select"
                        placeholder="Select"
                        isClearable={isClearable}
                        isLoading={isLoading}
                        isSearchable={true}
                        value={value}
                        options={options}
                        onChange={onChange}
                    />
                </>
            )}
        />
    );
};

export default CustomSelect;