var Mail = (function() {
	function Mail(id, title, content, name, 
		srcEmail, destEmail) {
		this.id = id
		this.title = title
		this.content = content
		this.name = name
		this.srcEmail = srcEmail
		this.destEmail = destEmail
		this.fmm = new FeedbackMessagesManager()
	}
	Mail.prototype.isValid = function() {
		var titleIsValid = Validation.mandatoryFieldIsOk(this.title, "title", this.fmm);
		var contentIsValid = Validation.mandatoryFieldIsOk(this.content, "content", this.fmm);
		var nameIsValid = Validation.mandatoryFieldIsOk(this.name, "name", this.fmm);
		var srcEmailIsValid = Validation.mandatoryFieldIsOk(this.srcEmail, "source email", this.fmm) &&
			StringUtils.emailIsValid(this.srcEmail, "source email", this.fmm);
		var destEmailIsValid = Validation.mandatoryFieldIsOk(this.destEmail, "destination email", this.fmm) &&
			StringUtils.emailIsValid(this.destEmail, "destination email", this.fmm);;
		return titleIsValid && contentIsValid && nameIsValid && srcEmailIsValid && destEmailIsValid;
	}
	return Mail
})();