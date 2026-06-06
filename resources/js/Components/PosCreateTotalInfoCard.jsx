import React, { useEffect, useState } from 'react';
import CustomSelect from './CustomSelect';

const PosCreateTotalInfoCard = ({ setValue, control, register, data, selectInputOptions, setTotalAmountToPaid }) => {
    const [selectedVat, setSelectedVat] = useState({})
    const [adjustableTotal, setAdjustableTotal] = useState("")
    const [subTotal, setSubTotal] = useState("")
    const [total, setTotal] = useState("")
    const [vat, setVat] = useState("")
    
    useEffect(() => { 
        setValue('vat', selectInputOptions?.vats &&  selectInputOptions?.vats[0].value)                
        setSelectedVat(selectInputOptions?.vats &&  selectInputOptions?.vats[0])                
    }, [selectInputOptions])

    // set the total amount to paid on the pos Create Page
    useEffect(() => { 
       setTotalAmountToPaid(total)              
    }, [total])

    // set subtotal 
    useEffect(() => {         
        if (data?.totalSubTotal) {
            const newSubtotal =  Number(parseFloat(data?.totalSubTotal).toFixed(2))
            setSubTotal(newSubtotal)    
        }
    }, [data?.totalSubTotal])

    // vat calculation
    useEffect(() => {
        if (data?.totalSubTotal) {
            const newVat =  data?.totalSubTotal ? (Math.floor((data?.totalSubTotal * 5) / 100).toFixed(2)) : ""            
            setVat(newVat)
        }
    }, [data?.totalSubTotal])
   
    // adjustableTotal calculation
    useEffect(() => {
        if (vat, subTotal) {
            const newAdjustedTotal = (parseFloat(vat) + parseFloat(subTotal)).toFixed(2)
            setAdjustableTotal(newAdjustedTotal) 
            setTotal(newAdjustedTotal)
        }
    }, [vat, subTotal])

    useEffect(() => {
        
    },[])

    const handleDiscountChange = (value) => {
        // if (value === "") {
        //     setTotal(adjustableTotal)
        // }
        const t = (( parseFloat(adjustableTotal) - parseFloat(value || 0)).toFixed(2))
        setTotal(t)
    }
    return (
        <div className='shadow-lg mb-1'>
            <table className="w-100 card-table table table-bordered">
                <tbody>
                    <tr>
                        <td>Total Weight:</td>
                        <td>{data?.totalWeight || ""}</td>
                    </tr>
                    <tr>
                        <td>Total ST/DIA :</td>
                        <td>{data?.totalStDia || ""}</td>
                    </tr>
                    <tr>
                        <td>SubTotal :</td>
                        <td>{data?.totalSubTotal || ""}</td>
                    </tr>
                    <tr>
                        <td style={{padding: '5px 12.75px'}}>
                            <div style={{width: '100px'}}>
                                <CustomSelect                                                    
                                    name="vat"
                                    control={control}
                                    options={selectInputOptions?.vats}
                                    value={selectedVat}
                                    isClearable={false}
                                    // isLoading={true}
                                    onChange={(val) => {
                                        setSelectedVat(val)
                                        setValue( 'vat', val.value)
                                    }}
                                />
                            </div>
                        </td>
                        <td>{vat}</td>
                    </tr>
                    <tr>
                        <td>Adjustable Total</td>
                        <td>
                            {adjustableTotal}
                        </td>
                    </tr>  
                    <tr>
                        <td>Discount</td>
                        <td style={{padding: '5px 12.75px'}}>
                            <input
                                {...register(
                                    `discount`,
                                )}
                                style={{ width: '100%', height: '32px' }}
                                type="number"
                                onChange={(e)=>handleDiscountChange(e.target.value)}
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>
                            {total || ""}
                        </td>
                    </tr>                                   
                </tbody>
            </table>
        </div>    
    );
};

export default PosCreateTotalInfoCard;