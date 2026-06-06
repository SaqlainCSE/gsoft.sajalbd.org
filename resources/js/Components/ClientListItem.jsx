export default function ClientListItem({item}) {
    
    return (
        <li>
            <div className="item">
                <img
                    src={item.photo}
                    alt="image"
                    className="image"
                />
                <div className="in">
                    <div>
                        <strong>{item.name}</strong>
                        <p className="mb-0 small">{item.mobile_number}</p>
                    </div>
                    <span className="text-muted">{item.category}</span>
                </div>
            </div>
        </li>
    );
}
