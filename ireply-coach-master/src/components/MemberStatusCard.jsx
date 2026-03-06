import '../styles/MemberStatusCard.css';

function MemberStatusCard({ memberStatuses, memberRequests, getStatusDotClass }) {
  return (
    <div className="card member-card">
      <div className="member-title">Member Status</div>
      {memberStatuses.map((member) => (
        <div key={member.name} className="member-line">
          <span>{member.name}</span>
          <span className="member-status-text">{member.status}</span>
          <span className={getStatusDotClass(member.status)} />
        </div>
      ))}

      <div className="request-list">
        {memberRequests.map((member) => (
          <div key={member.name} className="request-row">
            <span>{member.name}</span>
            <span className="requesting">{member.request}</span>
            <button type="button" className="view-btn">View</button>
          </div>
        ))}
      </div>
    </div>
  );
}

export default MemberStatusCard;
