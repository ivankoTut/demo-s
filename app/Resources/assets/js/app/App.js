import React, { Component } from 'react';
import LinkForm from './LinkForm';
import LinksList from './links/LinksList';


class App extends Component {
    render() {
        return (
            <div className="container-fluid">
                <h2 className="text-center">The service of short links</h2>

                <div className="row">
                    <LinkForm />
                </div>

                <div className="row">
                    <div className="col-md-8 col-md-offset-2">
                        <h3>Latest 10 links</h3>
                        <LinksList/>
                    </div>
                </div>
            </div>
        );
    }
}

export default App;