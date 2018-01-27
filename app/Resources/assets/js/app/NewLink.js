import React, {Component} from 'react';

export default class NewLink extends Component {
    constructor(props) {
        super(props);
        this.state = {link: props.link};
    }

    componentWillReceiveProps(nextProps) {
        this.setState({link: nextProps.link});
        return true;
    }

    render() {
        let hidden = this.state.link ? {display: 'block'} : {display: 'none'};

        return (
            <div>
                <div className="row" style={hidden}>
                    <div className="col-lg-8 col-lg-offset-2">
                        <h4>Your link</h4>
                        <div className="well">
                            <a href={location.origin + '/' + this.state.link.short_link} target="_blank">
                                {location.origin + '/' + this.state.link.short_link}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}