import React, {Component} from 'react';

export default class FullLinkField extends Component {
    constructor(props) {
        super(props);

        this.state = {value: props.value, valid: false, error: props.error};
        this.onChange = this.onChange.bind(this);
    }

    validate(val) {
        if(val.length < 10){
            this.setState({
                value: val,
                error: {
                    text: 'Must be more than 10 characters',
                    status: true
                }
            });
        } else {
            this.setState({
                value: val,
                error: {
                    text: '',
                    status: false
                }
            });
        }
    }

    onChange(e) {
        let val = e.target.value;
        this.validate(val);
    }

    componentWillReceiveProps(nextProps){
        this.setState({
            error: nextProps.error
        });
        return true;
    }

    render() {
        let hidden = this.state.error.status ? 'block' : 'hidden';

        return (
            <div className={this.state.error.status ? 'form-group has-error' : 'form-group'}>
                <label className="control-label">Full link</label>
                <input type="text" className="form-control" placeholder="full link"
                       value={this.state.value}
                       onChange={this.onChange}
                       />
                <span className="help-block" style={{display: hidden}}>
                    {this.state.error.text}
                </span>
            </div>
        );
    }
}