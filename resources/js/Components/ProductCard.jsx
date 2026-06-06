import React, { useEffect, useState } from 'react';
import MobileTableInput from './MobileTableInput';
import InputError from './InputError';

const ProductCard = ({errors, item, cancelProduct, register, index, setValue, totalWeightCount, totalSubTotalCount, totalStDiaCount}) => {
    const [price, setPrice] = useState("")
    const [newWage, setNewWage] = useState("")
    const [isCustomWage, setIsCustomWage] = useState(false)
    const [subTotal, setSubTotal] = useState("")
    // console.log(item)

    useEffect(() => {
        if (item?.weight) {
            totalWeightCount(item?.weight || 0, index)
            setValue(`products.${index}.weight`, item?.weight || 0)
        }        
    }, [item?.weight])

    useEffect(() => {   
        if (item?.st_dia) {
            totalStDiaCount(item?.st_dia || 0, index)            
        }
    }, [item?.st_dia])
    
    useEffect(() => {  
        if(subTotal) totalSubTotalCount(subTotal || 0, index)
    }, [subTotal])

    const onPriceChange = (price) => { 
        if (price === "") {
            setSubTotal("")
            setNewWage("")
            setValue(`products.${index}.wage`, "")
            return
        }
        
        setPrice(price)
        setValue(`products.${index}.unit_price`, price, { shouldValidate: true })

        let wage 
        if (isCustomWage) {
            wage = newWage
        } else {
            wage =((parseFloat(item.weight) * parseFloat(price)) * parseFloat(item?.wage / 100 || 0))                   
            setNewWage(wage.toFixed(0))
            setValue(`products.${index}.wage`, wage.toFixed(0), { shouldValidate: true })
        }

        const newSubtotal = ((item.weight * price)) + parseFloat(wage) + (item.st_dia_price || 0)
        setSubTotal(Math.ceil(newSubtotal).toFixed(2))
        // setSubTotal(Math.ceil(newSubtotal).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }))
    }
    
    const onWageChange = (wage) => { 
        setIsCustomWage(true)
        setNewWage(wage || 0)
        const newSubtotal = ((item.weight * price)) + parseFloat(wage || 0) + (item.st_dia_price || 0)        
        setSubTotal(Math.ceil(newSubtotal).toFixed(2))
    }

    return (
        <div className="card shadow-sm mb-2">
            {
                item?.weight && 
                <>
                    <div className="card-header d-flex justify-content-between" style={{backgroundColor: '#474747'}}>
                        <span>Product NR: {item.product_nr}</span>
                        {item.status === "Fresh" && (
                            <span className="badge badge-danger px-3 text-right">
                                {item.status}
                            </span>
                        )}
                        {item.status !== "Fresh" && (                    
                            <span onClick={()=>cancelProduct(index, item)} className="badge badge-secondary px-3 text-right">
                                X
                            </span>
                        )}
                    </div>
                    <div className="card-body p-0">
                        <table className="w-100 table table-bordered">
                            <tbody>
                                <tr>
                                    <td colSpan={4} className="py-2">
                                        {item?.product_details}
                                    </td>
                                </tr>
                                <tr className='d-none'>
                                    <td>
                                        <input
                                            {...register(
                                                `products.${index}.id`,
                                            )}
                                            type="number"
                                            defaultValue={item.id}
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Weight:</td>
                                    <td>
                                        {item?.weight}
                                    </td>

                                    <td>Price:</td>
                                    <td style={{padding: '5px', width: '100px'}}>                                        
                                        <MobileTableInput
                                            register={register}
                                            name={`products.${index}.unit_price`}
                                            type="number"
                                            defaultValue={item?.price || ""}
                                            onChange={(e)=>onPriceChange(e.target.value)}
                                        />
                                        {errors && errors[index]?.unit_price &&
                                            <InputError
                                                message={errors[index]?.unit_price.message}
                                            />
                                        }
                                    </td>
                                </tr>
                                <tr>
                                    <td>ST/DIA</td>
                                    <td>{item?.st_dia}</td>
                                    <td>Price:</td>
                                    <td style={{padding: '5px', width: '100px'}}>                                        
                                        <MobileTableInput
                                            register={register}
                                            name={`products.${index}.st_dia_price`}
                                            type="number"
                                            isRequired={item?.st_dia}
                                            disabled={!item?.st_dia}
                                        />
                                        {errors && errors[index]?.st_dia_price &&
                                            <InputError
                                                message={errors[index]?.st_dia_price.message}
                                            />
                                        }
                                    </td>
                                </tr>
                                <tr>
                                    <td>Wage</td>
                                    <td style={{padding: '5px', width: '100px'}}>                                        
                                        <MobileTableInput
                                            register={register}
                                            name={`products.${index}.wage`}
                                            type="number"
                                            defaultValue={newWage || ""}
                                            onChange={(e)=>onWageChange(e.target.value)}
                                        />
                                        {errors && errors[index]?.wage &&
                                            <InputError
                                                message={errors[index]?.wage.message}
                                            />
                                        }
                                    </td>

                                    <td>Subtotal:</td>
                                    <td  style={{padding: '5px', width: '100px'}}>
                                        {subTotal}
                                    </td>
                                </tr>                        
                                <tr className='d-none'>
                                    <td>    
                                        <input
                                            {...register(
                                                `products.${index}.st_dia_price`,
                                                { required: false }
                                            )}
                                            className='w-100' 
                                            style={{ height: '32px' }}
                                            type="number"
                                            defaultValue={item?.st_dia_price || ""}
                                            onChange={(e)=>onWageChange(e.target.value)}
                                        />
                                    </td>
                                </tr>                        
                            </tbody>                    
                        </table>               
                    </div>
                </>
            }
        </div>
    );
};

export default ProductCard;