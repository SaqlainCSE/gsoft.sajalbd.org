export default function ProductListItem({ item }) {
    return (
        <div className="card shadow-sm mb-1">
            <div className="card-header d-flex justify-content-between">
                <span>Product NR: {item.product_nr}</span>
                {item.status === "Fresh" && (
                    <span className="badge badge-warning px-3 text-right">
                        {item.status}
                    </span>
                )}
                {item.status !== "Fresh" && (
                    <span className="badge badge-secondary px-3 text-right">
                        {item.status}
                    </span>
                )}
            </div>
            <div className="card-body p-0">
                <table className="w-100 table table-bordered">
                    <tbody>
                        <tr>
                            <td colSpan={4} className="py-2">
                                {item.product_details}
                            </td>
                        </tr>
                        <tr>
                            <td>Weight:</td>
                            <td className="text-right">{item.weight}</td>
                            <td>ST/DIA:</td>
                            <td className="text-right">{item.st_dia}</td>
                        </tr>
                        <tr>
                            <td>Wage</td>
                            <td className="text-right">{item.wage}</td>
                            <td>ST/DIA Price:</td>
                            <td className="text-right">{item.st_dia_price}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    );
}
