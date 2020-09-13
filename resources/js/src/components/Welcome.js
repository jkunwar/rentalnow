import React, { PureComponent } from 'react';
import { Button } from 'antd';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import config from '../config';
import { bindActionCreators } from 'redux'
import { actions as loginAction } from '../actions/auth';

class Welcome extends PureComponent {

    componentDidMount() {
        const { location } = this.props;
        const provider = location.pathname.split('/')[2];
        const callbackToken = location.search;

        if (provider && callbackToken) {
            this.props.login({ provider, callbackToken });
        }
    }

    handleLogout = () => this.props.logout();

    render() {
        const { user, isAuthenticated } = this.props
        if (isAuthenticated) {
            return (
                <>
                    <h1>{user.name}</h1>
                    <img src={`${config.baseURI}/${user.profile_image}`} />
                    <button onClick={this.handleLogout}>Logout</button>
                </>
            )
        }
        return (
            <div style={{ width: 400, margin: '100px auto' }}>
                <Button type="primary" loading={this.props.loading} href="/login/google">Login with Google</Button>
            </div >
        );
    }

}

Welcome.propTypes = {
    login: PropTypes.func.isRequired
}

const mapStateToProps = (state) => {
    return {
        loading: state.login.loading,
        isAuthenticated: state.login.isAuthenticated,
        user: state.login.data.user
    }
}

const mapDispatchToProps = (dispatch) => ({
    ...bindActionCreators({ ...loginAction }, dispatch)
})

export default connect(mapStateToProps, mapDispatchToProps)(Welcome);