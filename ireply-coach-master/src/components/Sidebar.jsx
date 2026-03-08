function Sidebar({ logo, onLogoutClick, userRole, onRoleChange }) {
  const handleRoleSwitch = () => {
    const newRole = userRole === 'team_coach' ? 'employee' : 'team_coach';
    onRoleChange(newRole);
  };

  return (
    <aside className="sidebar">
      <div className="sidebar-top">
        <div className="brand">
          <img src={logo} alt="iREPLY logo" className="sidebar-logo" />
        </div>

        <div className="profile-logo" aria-label="Profile logo">
          <div className="profile-head" />
          <div className="profile-body" />
        </div>

        <div className="user-name">DLGG</div>

        <div className="role-display">
          Role: <span className="role-badge">{userRole === 'team_coach' ? 'Team Coach' : 'Employee'}</span>
        </div>

        <nav className="nav-menu">
          <button type="button" className="nav-item active">Dashboard</button>
          <button type="button" className="nav-item">Team</button>
          <button type="button" className="nav-item">Attendance</button>
        </nav>
      </div>

      <div className="sidebar-buttons">
        <button type="button" className="role-switch-btn" onClick={handleRoleSwitch}>
          Switch to {userRole === 'team_coach' ? 'Employee' : 'Team Coach'}
        </button>
        <button type="button" className="logout-btn" onClick={onLogoutClick}>Log Out</button>
      </div>
    </aside>
  );
}

export default Sidebar;
 