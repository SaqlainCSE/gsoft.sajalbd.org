import React, { useRef } from 'react';

const MobileTableInput = ({ name, isRequired = true, type, defaultValue, onChange, register, disabled = false }) => {

    return (
        <input
            {...register(
                name,
                { required: isRequired ?  'Required' : false }
            )}
            className='w-100' style={{ height: '32px' }}
            type={type}
            defaultValue={defaultValue}
            onChange={onChange}
            disabled={disabled}
        />
    );
};
export default MobileTableInput;