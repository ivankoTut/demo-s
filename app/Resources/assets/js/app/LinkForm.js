import React, {Component} from 'react';

import FullLinkField from './form/FullLinkField';
import ShortLinkField from './form/ShortLinksField';
import NewLink from './NewLink';

import axios from 'axios';

export default class LinkForm extends Component {
    constructor(props) {
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.state = {
            link: false,
            fullLink: {
                text: '',
                status: false
            },
            shortLink: {
                text: '',
                status: false
            }
        };

        this.sendForm = false;
    }

    handleSubmit(e) {
        e.preventDefault();

        if (this.sendForm) {
            return false;
        }
        this.sendForm = true;

        let fullLink = this.refs.fullLink.state.value;
        let shortLink = this.refs.shortLink.state.value;

        if (this.refs.fullLink.state.error.value === '') {
            this.setState({
                fullLink: {
                    text: 'Field full link is required',
                    status: true
                }
            });
            return false;
        }

        axios.post('/app_dev.php/api/link', {
            'full_link': fullLink,
            'short_link': shortLink
        }).then(response => {
            this.sendForm = false;
            if (response.data.status === "error") {
                this.showErrors(response.data.errors);
                return false;
            }

            this.showNewLink(response.data.link);
        }).catch(error => {
            this.sendForm = false;
            console.log(error);
        });
    }

    showNewLink(link) {
        this.setState({
            link: link,
            fullLink: {
                status: false
            },
            shortLink: {
                status: false
            }
        });
    }

    showErrors(errors) {
        let obj = {};

        this.setState({
            fullLink: {
                status: false
            },
            shortLink: {
                status: false
            }
        });

        errors.map(function (el) {
            obj[el.property_path] = {
                text: el.message,
                status: true
            };
        });

        this.setState(obj);
    }

    render() {

        return (
            <div>
                <div className="row">
                    <div className="col-lg-8 col-lg-offset-2">
                        <form className="form" onSubmit={this.handleSubmit}>
                            <FullLinkField value="" error={this.state.fullLink} ref="fullLink"/>
                            <ShortLinkField value="" error={this.state.shortLink} ref="shortLink"/>
                            <button type="submit" className="btn btn-primary mb-2">Confirm identity</button>
                        </form>
                    </div>
                </div>
                <br/>
                <NewLink link={this.state.link}/>
            </div>
        );
    }
}