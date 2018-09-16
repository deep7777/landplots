var smsMessage = $('#smsMessage');
if (smsMessage.length) {
  smsMessage.simplyCountable({
    counter: '#smsMessageCounter',
    maxCount: 160,
    strictMax: true,
    countDirection: 'up'
  });
}