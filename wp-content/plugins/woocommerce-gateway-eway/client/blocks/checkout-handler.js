/**
 * External dependencies
 */
import { useEffect } from '@wordpress/element';

/**
 * Internal dependencies
 */
import { getEWAYServerData } from './eway-utils';

export const CheckoutHandler = ( {
	eventRegistration,
	emitResponse,
	selectedCard,
} ) => {
	const {
		onCheckoutAfterProcessingWithError,
		onPaymentProcessing,
	} = eventRegistration;
	const showSavedCards = getEWAYServerData()?.showSavedCards || false;

	// Set nonce and card id when Eway should save cards.
	useEffect( () => {
		const onSubmit = () => {
			const paymentMethodData = showSavedCards
				? {
						_eway_nonce: getEWAYServerData()?.nonce,
						eway_card_id: selectedCard,
				  }
				: {};
			return {
				type: emitResponse.responseTypes.SUCCESS,
				meta: {
					paymentMethodData,
				},
			};
		};
		const unsubscribeProcessing = onPaymentProcessing( onSubmit );
		return () => {
			unsubscribeProcessing();
		};
	}, [
		onPaymentProcessing,
		emitResponse.responseTypes.SUCCESS,
		selectedCard,
		showSavedCards,
	] );

	// Show inline error message when using a saved card fails.
	useEffect( () => {
		const showError = ( checkoutResponse ) => {
			const { processingResponse } = checkoutResponse;
			return {
				type: emitResponse.responseTypes.ERROR,
				message: processingResponse?.paymentDetails?.message,
				messageContext: emitResponse.noticeContexts.PAYMENTS,
				retry: true,
			};
		};
		const unsubscribeCheckoutCompleteFail = onCheckoutAfterProcessingWithError(
			showError
		);
		return () => {
			unsubscribeCheckoutCompleteFail();
		};
	}, [
		onCheckoutAfterProcessingWithError,
		emitResponse.responseTypes.ERROR,
		emitResponse.noticeContexts.PAYMENTS,
	] );

	return null;
};
