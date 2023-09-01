/**
 * External dependencies
 */
import { decodeEntities } from '@wordpress/html-entities';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import { CheckoutHandler } from './checkout-handler';
import { getEWAYServerData } from './eway-utils';

const ComponentCreditCard = ( { emitResponse, eventRegistration } ) => {
	const {
		description = '',
	} = getEWAYServerData();

	return (
		<>
			<CheckoutHandler
				emitResponse={ emitResponse }
				eventRegistration={ eventRegistration }
				selectedCard="new"
			/>
			{ decodeEntities( description ) }
		</>
	);
};

export default ComponentCreditCard;
