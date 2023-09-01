/**
 * Internal dependencies
 */
import { CheckoutHandler } from './checkout-handler';

const ComponentSavedToken = ( { eventRegistration, emitResponse, token } ) => {
	return (
		<CheckoutHandler
			emitResponse={ emitResponse }
			eventRegistration={ eventRegistration }
			selectedCard={ token }
		/>
	);
};

export default ComponentSavedToken;
