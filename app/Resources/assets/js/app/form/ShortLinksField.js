import React, {Component} from 'react';

export default class ShortLinksField extends Component {
    constructor(props) {
        super(props);

        this.state = {value: props.value, valid: true, error: props.error};
        this.onChange = this.onChange.bind(this);
    }

    validate(val) {
        return true;
    }

    onChange(e) {
        let val = e.target.value;
        let isValid = this.validate(val);
        this.setState({value: val, valid: isValid});
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
                <label className="control-label">Short links(optional)</label>
                <input type="text" className="form-control" placeholder="short links"
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