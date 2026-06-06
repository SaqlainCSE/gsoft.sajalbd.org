import React, { useRef, useState } from 'react';
import CustomSelect from './CustomSelect';
import InputError from './InputError';
import MobileTableInput from './MobileTableInput';

const PaymentCardBody = ({errors, selectInputOptions, control, index, cancelPaymentOption, register, setValue, onPaymentAmountChange, selectInputOptionsLoading }) => {
    const [selectedPaymentType, setSelectedPaymentType] = useState('')
    const [selectedPaymentInfo, setSelectedPaymentInfo] = useState('')

    const handlePayAmountChange = (value) => {
        onPaymentAmountChange(value, index)
        setValue(`payments.${index}.amount`, value, { shouldValidate: true })
    }

    const referenceInputRef = useRef()
    const amountInputRef = useRef()
    return (
        <div className="card-body p-0">
            <table className="w-100 table card-table table-bordered">
                <tbody>
                    {
                        index !== 0 &&
                        <tr style={{ backgroundColor: '#f4f4f4' }}>
                            <td style={{ padding: '5px', textAlign: 'end' }} colSpan={2}>
                                {index !== 0 && (
                                    <span onClick={cancelPaymentOption} className="badge badge-danger px-3 text-right">
                                        X
                                    </span>
                                )}
                            </td>
                        </tr>
                    }                    
                    <tr>
                        <td>
                            Payment Type                                        
                        </td>
                        <td style={{ padding: '5px' }}>
                            <CustomSelect                                                                                            
                                options={selectInputOptions?.payment_type}
                                name={`payments.${index}.payment`}                                
                                control={control}
                                isLoading={selectInputOptionsLoading}
                                isRequired={true}
                                value={selectedPaymentType}
                                onChange={(val) => {
                                    setSelectedPaymentType(val)
                                    setValue(
                                        `payments.${index}.payment`,
                                        val ? val.value : "",
                                        { shouldValidate: true }
                                    );
                                }}
                            />  
                            {errors && errors[index]?.payment &&
                                <InputError
                                    message={errors[index]?.payment.message}
                                />
                            }
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Payment Info                                       
                        </td>
                        <td style={{padding: '5px'}}>
                            <CustomSelect
                                name={`payments.${index}.payment_info`}
                                options={selectInputOptions?.payment_methods}
                                control={control}
                                value={selectedPaymentInfo}
                                isLoading={selectInputOptionsLoading}
                                isRequired={true}
                                onChange={(val) => {
                                    setSelectedPaymentInfo(val)
                                    setValue(
                                        `payments.${index}.payment_info`,
                                        val ? val.value : "",
                                        { shouldValidate: true }
                                    );
                                }}
                            />
                            {errors && errors[index]?.payment_info &&
                                <InputError
                                    message={errors[index]?.payment_info.message}
                                />
                            }
                        </td>
                    </tr>
                    <tr>
                        <td>Reference</td>
                        <td style={{ padding: '5px' }}>    
                            <MobileTableInput
                                register={register}
                                name={`payments.${index}.reference`}
                                type="number"
                                isRequired={false}
                             />
                        </td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td style={{padding: '5px'}}>
                            <MobileTableInput
                                register={register}
                                name={`payments.${index}.amount`}
                                type="number"
                                onChange={(e)=>handlePayAmountChange(e.target.value)}
                            />
                            {errors && errors[index]?.amount &&
                                <InputError
                                    message={errors[index]?.amount.message}
                                />
                            }
                        </td>
                    </tr>                       
                </tbody>                    
            </table>               
        </div>
    );
};

export default PaymentCardBody;