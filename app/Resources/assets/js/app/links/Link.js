import React, {Component} from 'react';

export default class Link extends Component {
    constructor(props) {
        super(props);
        this.state = {link: props.link};
    }


    render() {

        return (
            <tr>
                <th scope="row">{this.state.link.id}</th>
                <td>{this.state.link.full_link}</td>
                <td>{this.state.link.short_link}</td>
                <td>{this.state.link.count_visit}</td>
                <td><a href={location.origin + '/' + this.state.link.short_link} target="_blank">go</a></td>
            </tr>
        );
    }
}